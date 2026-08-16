<?php

namespace App\Console\Commands;

use App\Exceptions\SupabaseAuthException;
use App\Models\Pengguna;
use App\Models\User;
use App\Services\SupabaseAuthService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SupabaseCreateUser extends Command
{
    protected $signature = 'supabase:create-user
        {email : Alamat email akun}
        {--name= : Nama lengkap (default: bagian depan email)}
        {--role=pelanggan : Peran akun (pelanggan atau admin)}
        {--password= : Password (default: acak, dicetak ke layar)}';

    protected $description = 'Buat akun di Supabase Auth dan sinkronkan ke tabel users & pengguna';

    public function handle(SupabaseAuthService $auth): int
    {
        $email = (string) $this->argument('email');
        $role = $this->option('role');
        $name = $this->option('name') ?: $this->defaultName($email);

        if (! in_array($role, ['pelanggan', 'admin'], true)) {
            $this->error('Role harus bernilai "pelanggan" atau "admin".');

            return self::FAILURE;
        }

        if ($auth->serviceRoleKey() === '') {
            $this->error('SUPABASE_SERVICE_ROLE_KEY wajib diisi di .env.');

            return self::FAILURE;
        }

        $password = $this->option('password') ?: Str::random(16);

        try {
            $userData = $auth->createAdminUser($email, $password, ['nama' => $name]);
        } catch (SupabaseAuthException $e) {
            $existing = $auth->findAdminUserByEmail($email);

            if (! $existing) {
                $this->error('Gagal membuat akun di Supabase: '.$e->getMessage());

                return self::FAILURE;
            }

            $this->warn('Akun sudah ada di Supabase — hanya menyinkronkan ke database lokal.');

            $userData = $existing;
        }

        $uuid = $userData['id'] ?? null;

        if (! $uuid) {
            $this->error('Supabase tidak mengembalikan ID pengguna.');

            return self::FAILURE;
        }

        $user = User::where('supabase_id', $uuid)->first();

        if (! $user) {
            $user = User::create([
                'supabase_id' => $uuid,
                'name' => $name,
                'email' => $email,
                'password' => null,
            ]);
        }

        $pengguna = Pengguna::firstOrNew(['user_id' => $user->id]);
        $pengguna->nama = $name;
        $pengguna->email = $email;
        $pengguna->password = null;
        $pengguna->role = $role;
        $pengguna->save();

        $this->info("Akun {$email} (role: {$role}) berhasil disinkronkan.");
        $this->warn("Password: {$password}");
        $this->line('Segera ganti password setelah login pertama.');

        return self::SUCCESS;
    }

    protected function defaultName(string $email): string
    {
        return ucwords(str_replace(['.', '_', '-'], ' ', (string) (strstr($email, '@', true) ?: $email)));
    }
}
