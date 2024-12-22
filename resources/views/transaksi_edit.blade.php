@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Edit Data Transaksi
                    </div>

                    <div class="card-body">
                        <form action="{{ url('transaksi/' . $transaksi->id) }}" method="post">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
                                <input id="tanggal_pemesanan" class="form-control" type="date" name="tanggal_pemesanan"
                                    value="{{ $transaksi->tanggal_pemesanan ?? old('tanggal_pemesanan') }}">
                                <span class="text-danger">{{ $errors->first('tanggal_pemesanan') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input id="tanggal_mulai" class="form-control" type="date" name="tanggal_mulai"
                                    value="{{ $transaksi->tanggal_mulai ?? old('tanggal_mulai') }}">
                                <span class="text-danger">{{ $errors->first('tanggal_mulai') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input id="tanggal_selesai" class="form-control" type="date" name="tanggal_selesai"
                                    value="{{ $transaksi->tanggal_selesai ?? old('tanggal_selesai') }}">
                                <span class="text-danger">{{ $errors->first('tanggal_selesai') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="pengguna_id">Pengguna</label>
                                <select id="pengguna_id" class="form-control" name="pengguna_id">
                                    <option value="">Pilih Pengguna</option>
                                    @foreach ($list_pengguna as $id => $nama)
                                        <option value="{{ $id }}" @selected($id == old('pengguna_id'))>{{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('pengguna_id') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="mobil_id">Mobil</label>
                                <select id="mobil_id" class="form-control" name="mobil_id">
                                    <option value="">Pilih Mobil</option>
                                    @foreach ($list_mobil as $id => $nama)
                                        <option value="{{ $id }}" @selected($id == old('mobil_id'))>
                                            {{ $nama }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('mobil_id') }}</span>
                            </div>


                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <input id="total_harga" class="form-control" type="number" name="total_harga"
                                    value="{{ $transaksi->total_harga ?? old('total_harga') }}">
                                <span class="text-danger">{{ $errors->first('total_harga') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="status_pembayaran">Status Pembayaran</label>
                                <select id="status_pembayaran" class="form-control" name="status_pembayaran">
                                    <option value="pending" @selected($transaksi->status_pembayaran == 'pending')>Pending</option>
                                    <option value="lunas" @selected($transaksi->status_pembayaran == 'lunas')>Lunas</option>
                                    <option value="batal" @selected($transaksi->status_pembayaran == 'batal')>Batal</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('status_pembayaran') }}</span>
                            </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
