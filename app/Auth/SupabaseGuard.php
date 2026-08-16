<?php

namespace App\Auth;

use App\Models\Pengguna;
use App\Models\User;
use App\Services\SupabaseAuthService;
use Firebase\JWT\ExpiredException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class SupabaseGuard implements Guard
{
    public const ACCESS_TOKEN_KEY = 'supabase.access_token';

    public const REFRESH_TOKEN_KEY = 'supabase.refresh_token';

    protected ?Authenticatable $user = null;

    protected UserProvider $provider;

    protected Session $session;

    protected SupabaseAuthService $auth;

    protected ?Request $request = null;

    public function __construct(UserProvider $provider, Session $session, SupabaseAuthService $auth)
    {
        $this->provider = $provider;
        $this->session = $session;
        $this->auth = $auth;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return \App\Models\User|null
     */
    public function user()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $token = $this->session->get(self::ACCESS_TOKEN_KEY);

        if (! $token) {
            return null;
        }

        try {
            $payload = $this->auth->decodeAndVerify($token);
        } catch (ExpiredException $e) {
            $session = $this->auth->refresh($this->session->get(self::REFRESH_TOKEN_KEY));

            if (! $session || empty($session['access_token'])) {
                $this->logout();

                return null;
            }

            $this->rememberSession($session);

            try {
                $payload = $this->auth->decodeAndVerify($session['access_token']);
            } catch (\Throwable $e2) {
                $this->logout();

                return null;
            }
        } catch (\Throwable $e) {
            $this->logout();

            return null;
        }

        $uuid = $payload['sub'] ?? null;

        if (! $uuid) {
            $this->logout();

            return null;
        }

        $this->user = User::where('supabase_id', $uuid)->first()
            ?? $this->syncLocalUser($uuid, $payload);

        return $this->user;
    }

    public function check(): bool
    {
        return $this->user() !== null;
    }

    public function guest(): bool
    {
        return $this->user() === null;
    }

    public function hasUser()
    {
        return $this->user !== null;
    }

    public function id()
    {
        $user = $this->user();

        return $user ? $user->getAuthIdentifier() : null;
    }

    public function validate(array $credentials = []): bool
    {
        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        if (! $email || ! $password) {
            return false;
        }

        try {
            $session = $this->auth->signIn($email, $password);
        } catch (\Throwable $e) {
            return false;
        }

        return ! empty($session['access_token']);
    }

    public function attempt(array $credentials = [], $remember = false): bool
    {
        $email = $credentials['email'] ?? null;
        $password = $credentials['password'] ?? null;

        if (! $email || ! $password) {
            return false;
        }

        try {
            $session = $this->auth->signIn($email, $password);
        } catch (\Throwable $e) {
            return false;
        }

        $userData = $session['user'] ?? null;
        $uuid = $userData['id'] ?? null;

        if (empty($session['access_token']) || ! $uuid) {
            return false;
        }

        $user = $this->syncLocalUser($uuid, $userData);

        if (! $user) {
            return false;
        }

        $this->rememberSession($session);
        $this->user = $user;

        return true;
    }

    /**
     * Loginkan user langsung dari hasil session Supabase (mis. setelah signup).
     */
    public function loginFromSupabase(array $session): ?User
    {
        $userData = $session['user'] ?? null;
        $uuid = $userData['id'] ?? null;

        if (empty($session['access_token']) || ! $uuid) {
            return null;
        }

        $user = $this->syncLocalUser($uuid, $userData);

        if (! $user) {
            return null;
        }

        $this->rememberSession($session);
        $this->user = $user;

        return $user;
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;

        return $this;
    }

    public function logout(): void
    {
        $token = $this->session->get(self::ACCESS_TOKEN_KEY);

        if ($token) {
            $this->auth->signOut($token);
        }

        $this->forgetSession();
        $this->user = null;
    }

    protected function syncLocalUser(string $uuid, array $data): ?User
    {
        $email = $data['email'] ?? null;
        $metadata = $data['user_metadata'] ?? [];
        $name = $metadata['nama'] ?? $metadata['name'] ?? null;

        if (! $name && $email) {
            $name = ucwords(str_replace(['.', '_', '-'], ' ', (string) (strstr($email, '@', true) ?: $email)));
        }

        $user = User::where('supabase_id', $uuid)->first();

        if (! $user) {
            $user = User::create([
                'supabase_id' => $uuid,
                'name' => $name ?: 'Pengguna',
                'email' => $email,
                'password' => null,
            ]);
        }

        $pengguna = Pengguna::firstOrNew(['user_id' => $user->id]);

        if (! $pengguna->exists) {
            $pengguna->fill([
                'nama' => $name ?: $user->name,
                'email' => $email,
                'password' => null,
                'role' => 'pelanggan',
            ]);
            $pengguna->save();
        }

        return $user;
    }

    protected function rememberSession(array $session): void
    {
        $this->session->put(self::ACCESS_TOKEN_KEY, $session['access_token'] ?? null);
        $this->session->put(self::REFRESH_TOKEN_KEY, $session['refresh_token'] ?? null);
    }

    protected function forgetSession(): void
    {
        $this->session->forget(self::ACCESS_TOKEN_KEY);
        $this->session->forget(self::REFRESH_TOKEN_KEY);
    }
}
