<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transaksi MODIFY status_pembayaran ENUM('pending','lunas','selesai','batal') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transaksi MODIFY status_pembayaran ENUM('pending','lunas','batal') NOT NULL DEFAULT 'pending'");
    }
};
