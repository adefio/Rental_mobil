<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ActivityLogger
{
    public function log(string $aksi, ?string $deskripsi = null): ActivityLog
    {
        $user = auth()->user();

        return ActivityLog::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'Sistem',
            'aksi' => $aksi,
            'deskripsi' => $deskripsi,
        ]);
    }

    public function paginated(int $perPage = 15): LengthAwarePaginator
    {
        return ActivityLog::query()->latest()->paginate($perPage);
    }
}
