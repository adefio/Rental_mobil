<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $defaults = [
            'nama_aplikasi' => 'Rental Mobil',
            'slogan' => 'Layanan penyewaan mobil terpercaya dengan armada pilihan dan harga bersahabat.',
            'alamat' => 'Jl. Raya Rental No. 123, Jakarta',
            'no_telepon' => '+62 812-3456-7890',
            'email_kontak' => 'halo@rentalmobil.com',
            'tarif_denda_per_hari' => '100000',
            'jam_operasional' => '08.00 - 20.00 WIB',
        ];

        $now = now();

        foreach ($defaults as $key => $value) {
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
