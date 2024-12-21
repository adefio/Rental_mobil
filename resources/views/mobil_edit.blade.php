@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Edit Data Mobil
                    </div>
                    <div class="card-body">
                        <form action="{{ url('mobil/' . $mobil->id) }}" method="POST">
                            @method('PUT')
                            @csrf

                            <div class="form-group">
                                <label for="nama_mobil">Nama Mobil</label>
                                <input id="nama_mobil" class="form-control" type="text" name="nama_mobil"
                                    value="{{ $mobil->nama_mobil ?? old('nama_mobil') }}">
                                <span class="text-danger">{{ $errors->first('nama_mobil') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="merk">Merk</label>
                                <input id="merk" class="form-control" type="text" name="merk"
                                    value="{{ $mobil->merk ?? old('merk') }}">
                                <span class="text-danger">{{ $errors->first('merk') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="tahun">Tahun</label>
                                <input id="tahun" class="form-control" type="number" name="tahun"
                                    value="{{ $mobil->tahun ?? old('tahun') }}">
                                <span class="text-danger">{{ $errors->first('tahun') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="harga_sewa">Harga Sewa</label>
                                <input id="harga_sewa" class="form-control" type="number" step="0.01" name="harga_sewa"
                                    value="{{ $mobil->harga_sewa ?? old('harga_sewa') }}">
                                <span class="text-danger">{{ $errors->first('harga_sewa') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" class="form-control" name="status">
                                    <option value="tersedia" @selected('tersedia' == $mobil->status)>Tersedia</option>
                                    <option value="disewa" @selected('disewa' == $mobil->status)>Disewa</option>
                                    <option value="maintenance" @selected('maintenance' == $mobil->status)>Maintenance</option>
                                </select>
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                            </div>

                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" class="form-control" name="deskripsi">{{ $mobil->deskripsi ?? old('deskripsi') }}</textarea>
                                <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
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
