@extends('layouts.admin')

@section('title', 'Tambah Pengembalian')

@section('content')
    <div class="card page-card form-card">
        <div class="card-header">
            <a href="{{ url('pengembalian') }}" class="btn btn-light btn-back" aria-label="Kembali ke Data Pengembalian">
                <x-icon name="arrow-left" class="icon-sm" />
            </a>
            Tambah Data Pengembalian
        </div>
        <div class="card-body">
            <form action="{{ url('pengembalian') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="transaksi_id">ID Transaksi</label>
                    <select id="transaksi_id" class="form-select" name="transaksi_id">
                        @foreach ($list_transaksi as $id => $value)
                            <option value="{{ $id }}" @selected($id == old('transaksi_id'))>{{ $value }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('transaksi_id') }}</span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="denda_telat">Denda Telat (Rp)</label>
                            <input id="denda_telat" class="form-control" type="number" step="0.01"
                                name="denda_telat" value="{{ old('denda_telat') }}">
                            <span class="text-danger">{{ $errors->first('denda_telat') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="biaya_kerusakan">Biaya Kerusakan (Rp)</label>
                            <input id="biaya_kerusakan" class="form-control" type="number" step="0.01"
                                name="biaya_kerusakan" value="{{ old('biaya_kerusakan') }}">
                            <span class="text-danger">{{ $errors->first('biaya_kerusakan') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi_kerusakan">Deskripsi Kerusakan</label>
                    <textarea id="deskripsi_kerusakan" class="form-control" name="deskripsi_kerusakan" rows="3">{{ old('deskripsi_kerusakan') }}</textarea>
                    <span class="text-danger">{{ $errors->first('deskripsi_kerusakan') }}</span>
                </div>

                <div class="form-group">
                    <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                    <input id="tanggal_pengembalian" class="form-control" type="date"
                        name="tanggal_pengembalian" value="{{ old('tanggal_pengembalian') }}">
                    <span class="text-danger">{{ $errors->first('tanggal_pengembalian') }}</span>
                </div>

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <x-icon name="check" class="icon-sm" />Simpan</button>
                <a href="{{ url('pengembalian') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
