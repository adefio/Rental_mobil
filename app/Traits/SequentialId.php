<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

/**
 * Trait untuk menghasilkan ID sequential yang mengisi gap.
 *
 * Ketika data dihapus (misal id=2), data baru berikutnya akan
 * menggunakan id=2 (mengisi gap), bukan melanjutkan auto-increment.
 *
 * Gunakan di model: use SequentialId;
 */
trait SequentialId
{
    public static function bootSequentialId(): void
    {
        static::creating(function ($model) {
            $model->id = $model->getNextSequentialId();
        });

        static::created(function ($model) {
            $model->resetSequence();
        });

        static::deleted(function ($model) {
            $model->resetSequence();
        });
    }

    /**
     * Cari ID terkecil yang belum dipakai (mengisi gap).
     * Jika tidak ada gap, gunakan max(id) + 1.
     */
    protected function getNextSequentialId(): int
    {
        $tableName = $this->getTable();
        $usedIds = DB::table($tableName)->pluck('id')->sort()->values()->toArray();

        if (empty($usedIds)) {
            return 1;
        }

        $nextId = 1;
        foreach ($usedIds as $id) {
            if ((int) $id !== $nextId) {
                break;
            }
            $nextId++;
        }

        return $nextId;
    }

    /**
     * Sinkronkan sequence PostgreSQL agar sesuai dengan max(id) aktual.
     */
    protected function resetSequence(): void
    {
        try {
            $tableName = $this->getTable();
            $sequence = $tableName . '_id_seq';
            $maxId = DB::table($tableName)->max('id') ?? 0;

            DB::statement("SELECT setval('{$sequence}', {$maxId})");
        } catch (\Exception $e) {
            // Sequence mungkin tidak ditemukan (nama berbeda di Supabase), abaikan
        }
    }
}
