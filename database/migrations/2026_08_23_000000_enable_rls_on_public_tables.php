<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = DB::select(
            "select tablename from pg_tables where schemaname = ? and rowsecurity = false",
            [$this->getSchema()]
        );

        foreach ($tables as $table) {
            DB::statement(sprintf(
                'alter table %s."%s" enable row level security;',
                $this->getSchema(),
                $table->tablename
            ));
        }
    }

    public function down(): void
    {
        foreach ([
            'pesan', 'sessions', 'settings', 'password_reset_tokens',
            'mobil', 'password_resets', 'pengembalian', 'transaksi',
            'pengguna', 'migrations', 'failed_jobs', 'users',
        ] as $table) {
            DB::statement(sprintf('alter table %s."%s" disable row level security;', $this->getSchema(), $table));
        }
    }

    private function getSchema(): string
    {
        return config('database.connections.pgsql.search_path') ?: 'public';
    }
};
