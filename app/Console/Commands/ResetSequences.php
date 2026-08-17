<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetSequences extends Command
{
    protected $signature = 'db:reset-sequences';
    protected $description = 'Reset semua PostgreSQL sequence agar sinkron dengan max(id) aktual di setiap tabel';

    public function handle(): int
    {
        $tables = ['users', 'mobil', 'pengguna', 'transaksi', 'pengembalian', 'pesan', 'settings'];

        foreach ($tables as $table) {
            $maxId = DB::table($table)->max('id') ?? 0;
            $sequence = $table . '_id_seq';

            try {
                DB::statement("SELECT setval('{$sequence}', {$maxId}, false)");
                $this->info("  {$table}: sequence diset ke {$maxId}");
            } catch (\Exception $e) {
                $this->warn("  {$table}: sequence '{$sequence}' tidak ditemukan, skip.");
            }
        }

        $this->info('Semua sequence berhasil disinkronkan.');
        return self::SUCCESS;
    }
}
