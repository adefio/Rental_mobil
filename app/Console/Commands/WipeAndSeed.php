<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WipeAndSeed extends Command
{
    protected $signature = 'db:wipe-seed
        {--force : Lewati konfirmasi}';

    protected $description = 'Hapus semua data, reset sequence, lalu re-seed dari awal (ID mulai dari 1)';

    public function handle(): int
    {
        $this->newLine();
        $this->info('=== RESET DATABASE & RE-SEED ===');
        $this->newLine();

        $this->warn('PERINGATAN: Semua data akan dihapus permanen!');
        if (!$this->option('force') && !$this->confirm('Lanjutkan?', false)) {
            $this->info('Dibatalkan.');
            return self::SUCCESS;
        }

        $this->wipeData();
        $this->resetSequences();
        $this->runSeeders();

        $this->newLine();
        $this->info('=== SELESAI ===');
        $this->info('Semua tabel sudah kosong, sequence direset ke 1, dan data seed sudah dimasukkan ulang.');
        return self::SUCCESS;
    }

    protected function wipeData(): void
    {
        $this->info('1. Menghapus semua data...');

        $tables = ['pengembalian', 'transaksi', 'pesan', 'pengguna', 'mobil', 'settings', 'users'];

        foreach ($tables as $table) {
            $count = DB::table($table)->count();
            DB::table($table)->truncate();
            $this->line("   {$table}: {$count} baris dihapus (TRUNCATE)");
        }
    }

    protected function resetSequences(): void
    {
        $this->info('2. Mereset PostgreSQL sequence ke 0...');

        $sequences = [
            'users_id_seq',
            'mobil_id_seq',
            'pengguna_id_seq',
            'transaksi_id_seq',
            'pengembalian_id_seq',
            'pesan_id_seq',
            'settings_id_seq',
        ];

        foreach ($sequences as $sequence) {
            try {
                $exists = DB::select(
                    "SELECT 1 FROM pg_sequences WHERE schemaname = 'public' AND sequencename = ?",
                    [$sequence]
                );

                if (empty($exists)) {
                    $this->warn("   {$sequence}: tidak ditemukan, skip.");
                    continue;
                }

                DB::statement("SELECT setval('{$sequence}', 1, false)");
                $this->line("   {$sequence} -> reset ke 0");
            } catch (\Exception $e) {
                $this->warn("   {$sequence}: gagal reset ({$e->getMessage()})");
            }
        }
    }

    protected function runSeeders(): void
    {
        $this->info('3. Menjalankan seeder...');

        $this->call(\Database\Seeders\DatabaseSeeder::class);
    }
}
