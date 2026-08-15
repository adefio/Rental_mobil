@extends('layouts.admin')

@section('title', 'Tambah Mobil')

@section('content')
    <div class="card page-card form-card">
        <div class="card-header">
            <a href="{{ url('mobil') }}" class="btn btn-light btn-back" aria-label="Kembali ke Data Mobil">
                <x-icon name="arrow-left" class="icon-sm" />
            </a>
            Tambah Data Mobil
        </div>
        <div class="card-body">
            <form action="{{ url('mobil') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nama_mobil">Nama Mobil</label>
                    <input id="nama_mobil" class="form-control" type="text" name="nama_mobil"
                        value="{{ old('nama_mobil') }}">
                    <span class="text-danger">{{ $errors->first('nama_mobil') }}</span>
                </div>

                <div class="form-group">
                    <label for="merk">Merk</label>
                    <input id="merk" class="form-control" type="text" name="merk" value="{{ old('merk') }}">
                    <span class="text-danger">{{ $errors->first('merk') }}</span>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input id="tahun" class="form-control" type="number" name="tahun"
                                value="{{ old('tahun') }}">
                            <span class="text-danger">{{ $errors->first('tahun') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-select" name="status">
                                <option value="tersedia" @selected('tersedia' == old('status'))>Tersedia</option>
                                <option value="disewa" @selected('disewa' == old('status'))>Disewa</option>
                                <option value="maintenance" @selected('maintenance' == old('status'))>Maintenance</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="harga_sewa">Harga Sewa (Rp)</label>
                    <input id="harga_sewa" class="form-control" type="number" step="1" name="harga_sewa"
                        value="{{ old('harga_sewa') }}">
                    <span class="text-danger">{{ $errors->first('harga_sewa') }}</span>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" class="form-control" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Mobil</label>
                    <input id="gambar" class="form-control" type="file" name="gambar[]" multiple
                        accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks 2MB per file. Bisa pilih lebih dari satu.</small>
                    <div id="gambarPreview" class="gambar-preview"></div>
                    <span class="text-danger">{{ $errors->first('gambar.*') ?: $errors->first('gambar') }}</span>
                </div>

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <x-icon name="check" class="icon-sm" />Simpan</button>
                <a href="{{ url('mobil') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('gambar')?.addEventListener('change', function () {
            const container = document.getElementById('gambarPreview');
            if (!container) return;
            container.innerHTML = '';
            Array.from(this.files || []).forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Pratinjau gambar';
                    img.className = 'gambar-preview-item';
                    container.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
