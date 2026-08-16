<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * - supabase_id: UUID pengguna dari Supabase Auth (nullable agar pelanggan
     *   walk-in/offline tetap bisa dicatat tanpa akun).
     * - password: dikelola oleh Supabase Auth, tidak lagi disimpan lokal.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('supabase_id', 36)->nullable()->unique()->after('id');
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['supabase_id']);
            $table->dropColumn('supabase_id');
            $table->string('password')->nullable(false)->change();
        });
    }
};
