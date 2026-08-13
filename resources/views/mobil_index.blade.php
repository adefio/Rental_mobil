@extends('layouts.admin')

@section('title', 'Data Mobil')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Data Mobil</h1>
            <p class="admin-page-sub mb-0">Kelola armada mobil yang tersedia untuk disewakan.</p>
        </div>
        <a href="{{ url('mobil/create') }}"
            class="btn btn-primary d-inline-flex align-items-center gap-2">
            <x-icon name="plus" class="icon-sm" /> Tambah Mobil
        </a>
    </div>

    <div
        data-vue="DataTable"
        data-title="Data Mobil"
        data-rows='@json($mobil->items())'
        data-edit-route="{{ url('mobil/__ID__/edit') }}"
        data-delete-route="{{ url('mobil/__ID__') }}"
        data-pagination='@json($pagination)'
        data-pagination-path="{{ $mobil->path() }}"
        data-columns='@json($columns)'
    ></div>
@endsection
