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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade'); // Menyambungkan dengan tabel transaksi
            $table->decimal('denda_telat', 8, 2)->nullable(); // Denda keterlambatan, bisa null
            $table->decimal('biaya_kerusakan', 8, 2)->nullable(); // Biaya kerusakan, bisa null
            $table->text('deskripsi_kerusakan')->nullable(); // Deskripsi kerusakan, bisa null
            $table->date('tanggal_pengembalian'); // Tanggal pengembalian mobil
            $table->timestamps(); // Waktu pencatatan data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
