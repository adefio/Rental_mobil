@extends('layouts.admin')

@section('title', 'Data Transaksi')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Data Transaksi</h1>
            <p class="admin-page-sub mb-0">Pantau seluruh transaksi penyewaan mobil, termasuk pesanan offline.</p>
        </div>
        <a href="{{ url('transaksi/create') }}"
            class="btn btn-primary d-inline-flex align-items-center gap-2">
            <x-icon name="plus" class="icon-sm" /> Terima Pesanan
        </a>
    </div>

    <div
        data-vue="DataTable"
        data-title="Data Transaksi"
        data-rows='@json($transaksi->items())'
        data-edit-route="{{ url('transaksi/__ID__/edit') }}"
        data-delete-route="{{ url('transaksi/__ID__') }}"
        data-detail-route="{{ url('transaksi/__ID__') }}"
        data-pagination='@json($pagination)'
        data-pagination-path="{{ $transaksi->path() }}"
        data-columns='@json($columns)'
    ></div>
@endsection
