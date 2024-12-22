<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            // Menambahkan kolom status_pengembalian dengan default 'pending'
            $table->enum('status_pengembalian', ['returned', 'damaged', 'late', 'pending'])->default('pending');

            // Menambahkan kolom waktu_pengembalian yang bisa nullable
            $table->timestamp('waktu_pengembalian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            // Menghapus kolom status_pengembalian dan waktu_pengembalian jika rollback
            $table->dropColumn('status_pengembalian');
            $table->dropColumn('waktu_pengembalian');
        });
    }
};
