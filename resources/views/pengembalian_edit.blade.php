@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Edit Data Pengembalian
                    </div>
                    <div class="card-body">
                        <form action="{{ url('pengembalian/' . $pengembalian->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="transaksi_id">ID Transaksi</label>
                                <select id="transaksi_id" class="form-control" name="transaksi_id">
                                    @foreach ($list_transaksi as $id => $value)
                                        <option value="{{ $id }}" @selected($id == $pengembalian->transaksi_id)>{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('transaksi_id') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="denda_telat">Denda Telat</label>
                                <input id="denda_telat" class="form-control" type="number" step="0.01"
                                    name="denda_telat" value="{{ $pengembalian->denda_telat ?? old('denda_telat') }}">
                                <span class="text-danger">{{ $errors->first('denda_telat') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="biaya_kerusakan">Biaya Kerusakan</label>
                                <input id="biaya_kerusakan" class="form-control" type="number" step="0.01"
                                    name="biaya_kerusakan"
                                    value="{{ $pengembalian->biaya_kerusakan ?? old('biaya_kerusakan') }}">
                                <span class="text-danger">{{ $errors->first('biaya_kerusakan') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi_kerusakan">Deskripsi Kerusakan</label>
                                <textarea id="deskripsi_kerusakan" class="form-control" name="deskripsi_kerusakan">{{ $pengembalian->deskripsi_kerusakan ?? old('deskripsi_kerusakan') }}</textarea>
                                <span class="text-danger">{{ $errors->first('deskripsi_kerusakan') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                                <input id="tanggal_pengembalian" class="form-control" type="date"
                                    name="tanggal_pengembalian"
                                    value="{{ $pengembalian->tanggal_pengembalian ?? old('tanggal_pengembalian') }}">
                                <span class="text-danger">{{ $errors->first('tanggal_pengembalian') }}</span>
                            </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
