<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if ($this->isPostgres()) {
            DB::statement('ALTER TABLE transaksi DROP CONSTRAINT IF EXISTS transaksi_status_pembayaran_check');
            DB::statement("ALTER TABLE transaksi ADD CONSTRAINT transaksi_status_pembayaran_check CHECK (status_pembayaran IN ('pending','lunas','selesai','batal'))");
        } else {
            DB::statement("ALTER TABLE transaksi MODIFY status_pembayaran ENUM('pending','lunas','selesai','batal') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        if ($this->isPostgres()) {
            DB::statement('ALTER TABLE transaksi DROP CONSTRAINT IF EXISTS transaksi_status_pembayaran_check');
            DB::statement("ALTER TABLE transaksi ADD CONSTRAINT transaksi_status_pembayaran_check CHECK (status_pembayaran IN ('pending','lunas','batal'))");
        } else {
            DB::statement("ALTER TABLE transaksi MODIFY status_pembayaran ENUM('pending','lunas','batal') NOT NULL DEFAULT 'pending'");
        }
    }

    private function isPostgres(): bool
    {
        return Schema::getConnection()->getDriverName() === 'pgsql';
    }
};
