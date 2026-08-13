@extends('layouts.admin')

@section('title', 'Data Pengguna')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Data Pengguna</h1>
            <p class="admin-page-sub mb-0">Kelola data pelanggan dan administrator sistem.</p>
        </div>
        <a href="{{ url('pengguna/create') }}"
            class="btn btn-primary d-inline-flex align-items-center gap-2">
            <x-icon name="plus" class="icon-sm" /> Tambah Pengguna
        </a>
    </div>

    <div
        data-vue="DataTable"
        data-title="Data Pengguna"
        data-rows='@json($pengguna->items())'
        data-edit-route="{{ url('pengguna/__ID__/edit') }}"
        data-delete-route="{{ url('pengguna/__ID__') }}"
        data-pagination='@json($pagination)'
        data-pagination-path="{{ $pengguna->path() }}"
        data-columns='@json($columns)'
    ></div>
@endsection
