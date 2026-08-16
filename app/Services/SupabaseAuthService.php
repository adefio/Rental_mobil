<?php

namespace App\Services;

use App\Exceptions\SupabaseAuthException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SupabaseAuthService
{
    public function baseUrl(): string
    {
        return rtrim((string) config('services.supabase.url'), '/');
    }

    public function anonKey(): string
    {
        return (string) config('services.supabase.anon_key');
    }

    public function serviceRoleKey(): string
    {
        return (string) config('services.supabase.service_role_key');
    }

    /**
     * Login dengan email & password via Supabase Auth (GoTrue).
     *
     * @return array{access_token: string, refresh_token: string, user: array}
     *
     * @throws SupabaseAuthException
     */
    public function signIn(string $email, string $password): array
    {
        $response = Http::withHeaders($this->headers())
            ->asJson()
            ->post($this->baseUrl().'/auth/v1/token?grant_type=password', [
                'email' => $email,
                'password' => $password,
            ]);

        $this->abortIfFailed($response);

        return $response->json();
    }

    /**
     * Buat akun lewat Admin API (tidak mengirim email konfirmasi).
     * Memerlukan service role key.
     *
     * @return array user
     *
     * @throws SupabaseAuthException
     */
    public function createAdminUser(string $email, string $password, array $metadata = []): array
    {
        if ($this->serviceRoleKey() === '') {
            throw new SupabaseAuthException('SUPABASE_SERVICE_ROLE_KEY wajib diisi di .env.');
        }

        $response = Http::withHeaders($this->headers(true))
            ->asJson()
            ->post($this->baseUrl().'/auth/v1/admin/users', [
                'email' => $email,
                'password' => $password,
                'email_confirm' => true,
                'user_metadata' => $metadata,
            ]);

        $this->abortIfFailed($response);

        return $response->json();
    }

    /**
     * Cari pengguna Supabase berdasarkan email (via Admin API).
     * Memerlukan service role key.
     */
    public function findAdminUserByEmail(string $email): ?array
    {
        if ($this->serviceRoleKey() === '') {
            return null;
        }

        $response = Http::withHeaders($this->headers(true))
            ->get($this->baseUrl().'/auth/v1/admin/users?per_page=1000');

        if ($response->failed()) {
            return null;
        }

        foreach ($response->json('users') ?? [] as $user) {
            if (strtolower($user['email'] ?? '') === strtolower($email)) {
                return $user;
            }
        }

        return null;
    }

    /**
     * Daftar akun baru di Supabase Auth.
     *
     * Menggunakan service role key (jika tersedia) agar email langsung
     * dikonfirmasi (`email_confirm: true`) dan session langsung tersedia.
     *
     * @return array{access_token?: string, user: array}
     *
     * @throws SupabaseAuthException
     */
    public function signUp(string $email, string $password, array $metadata = []): array
    {
        $useServiceRole = $this->serviceRoleKey() !== '';

        $payload = [
            'email' => $email,
            'password' => $password,
            'data' => $metadata,
        ];

        if ($useServiceRole) {
            $payload['email_confirm'] = true;
        }

        $response = Http::withHeaders($this->headers($useServiceRole))
            ->asJson()
            ->post($this->baseUrl().'/auth/v1/signup', $payload);

        $this->abortIfFailed($response);

        return $response->json();
    }

    /**
     * Logout dari Supabase (best-effort, gagal tidak apa-apa).
     */
    public function signOut(string $accessToken): void
    {
        try {
            Http::withHeaders($this->headers(false, $accessToken))
                ->post($this->baseUrl().'/auth/v1/logout');
        } catch (\Throwable $e) {
            // abaikan
        }
    }

    /**
     * Kirim email pemulihan password (Supabase mengirimkan tautannya).
     *
     * @throws SupabaseAuthException
     */
    public function recover(string $email): void
    {
        $response = Http::withHeaders($this->headers())
            ->asJson()
            ->post($this->baseUrl().'/auth/v1/recover', [
                'email' => $email,
            ]);

        $this->abortIfFailed($response);
    }

    /**
     * Tukar recovery token (dari tautan email Supabase) menjadi session.
     *
     * @return array{access_token: string, refresh_token: string, user: array}
     *
     * @throws SupabaseAuthException
     */
    public function verifyRecovery(string $token): array
    {
        $response = Http::withHeaders($this->headers())
            ->asJson()
            ->post($this->baseUrl().'/auth/v1/verify', [
                'type' => 'recovery',
                'token' => $token,
            ]);

        $this->abortIfFailed($response);

        return $response->json();
    }

    /**
     * Perbarui data akun (misal ganti password) di Supabase.
     *
     * @return array user
     *
     * @throws SupabaseAuthException
     */
    public function updateUser(string $accessToken, array $data): array
    {
        $response = Http::withHeaders($this->headers(false, $accessToken))
            ->asJson()
            ->put($this->baseUrl().'/auth/v1/user', $data);

        $this->abortIfFailed($response);

        return $response->json();
    }

    /**
     * Ganti password akun yang sedang login.
     *
     * @throws SupabaseAuthException
     */
    public function updatePassword(string $accessToken, string $password): array
    {
        return $this->updateUser($accessToken, ['password' => $password]);
    }

    /**
     * Perbarui session menggunakan refresh token.
     */
    public function refresh(string $refreshToken): ?array
    {
        $response = Http::withHeaders($this->headers())
            ->asJson()
            ->post($this->baseUrl().'/auth/v1/token?grant_type=refresh_token', [
                'refresh_token' => $refreshToken,
            ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json();
    }

    /**
     * Ambil detail pengguna dari Supabase.
     *
     * @throws SupabaseAuthException
     */
    public function getUser(string $accessToken): array
    {
        $response = Http::withHeaders($this->headers(false, $accessToken))
            ->get($this->baseUrl().'/auth/v1/user');

        $this->abortIfFailed($response);

        return $response->json();
    }

    /**
     * Verifikasi JWT access token Supabase dan kembalikan payload-nya (assoc).
     *
     * @throws ExpiredException bila token kedaluwarsa
     * @throws SupabaseAuthException bila token tidak valid
     */
    public function decodeAndVerify(string $token): array
    {
        $key = $this->jwtKey();

        if ($key === null) {
            throw new SupabaseAuthException('Supabase tidak dikonfigurasi dengan benar.');
        }

        try {
            $headers = null;
            $decoded = JWT::decode($token, $key, $headers);

            return (array) $decoded;
        } catch (ExpiredException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new SupabaseAuthException('Token Supabase tidak valid: '.$e->getMessage());
        }
    }

    /**
     * Key verifikasi: JWKS publik Supabase (RS256) atau JWT secret (HS256).
     *
     * @return \Firebase\JWT\Key|array|null
     */
    protected function jwtKey()
    {
        $jwks = Cache::remember('supabase.jwks', 3600, function () {
            try {
                $response = Http::get($this->baseUrl().'/auth/v1/.well-known/jwks.json');
            } catch (\Throwable $e) {
                return null;
            }

            return $response->ok() ? $response->json() : null;
        });

        if (is_array($jwks) && ! empty($jwks['keys'])) {
            return JWK::parseKeySet($jwks);
        }

        if ($secret = (string) config('services.supabase.jwt_secret')) {
            return new Key($secret, 'HS256');
        }

        return null;
    }

    protected function headers(bool $serviceRole = false, ?string $token = null): array
    {
        $key = $serviceRole ? $this->serviceRoleKey() : $this->anonKey();

        return [
            'apikey' => $key,
            'Authorization' => 'Bearer '.($token ?? $key),
            'Accept' => 'application/json',
        ];
    }

    /**
     * @throws SupabaseAuthException
     */
    protected function abortIfFailed(Response $response): void
    {
        if ($response->successful()) {
            return;
        }

        $body = $response->json();
        $message = $body['msg']
            ?? $body['message']
            ?? $body['error_description']
            ?? $body['error']
            ?? 'Terjadi kesalahan pada layanan Supabase.';

        if (is_array($message)) {
            $message = implode(', ', $message);
        }

        throw new SupabaseAuthException((string) $message, $response->status());
    }
}
