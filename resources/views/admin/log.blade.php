@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Log Aktivitas</h1>
            <p class="admin-page-sub mb-0">Riwayat aktivitas pengguna di dalam sistem, mulai dari login hingga perubahan data.</p>
        </div>
    </div>

    <div class="card page-card">
        <div class="card-header d-flex align-items-center gap-2">
            <span class="profile-section-icon"><x-icon name="activity" class="icon-sm" /></span>
            <span>Riwayat Aktivitas</span>
        </div>
        <div class="card-body p-0">
            <div
                data-vue="DataTable"
                data-title="Log Aktivitas"
                data-rows='@json($logs->items())'
                data-pagination='@json($pagination)'
                data-pagination-path="{{ $logs->path() }}"
                data-columns='@json($columns)'
            ></div>
        </div>
    </div>
@endsection
