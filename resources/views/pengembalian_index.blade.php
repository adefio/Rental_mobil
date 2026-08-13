@extends('layouts.admin')

@section('title', 'Data Pengembalian')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Data Pengembalian</h1>
            <p class="admin-page-sub mb-0">Kelola proses pengembalian mobil dari penyewa.</p>
        </div>
        <a href="{{ url('pengembalian/create') }}"
            class="btn btn-primary d-inline-flex align-items-center gap-2">
            <x-icon name="plus" class="icon-sm" /> Tambah Pengembalian
        </a>
    </div>

    <div
        data-vue="DataTable"
        data-title="Data Pengembalian"
        data-rows='@json($pengembalian->items())'
        data-edit-route="{{ url('pengembalian/__ID__/edit') }}"
        data-delete-route="{{ url('pengembalian/__ID__') }}"
        data-pagination='@json($pagination)'
        data-pagination-path="{{ $pengembalian->path() }}"
        data-columns='@json($columns)'
    ></div>
@endsection
