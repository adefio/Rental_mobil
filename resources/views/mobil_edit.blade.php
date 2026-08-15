@extends('layouts.admin')

@section('title', 'Edit Mobil')

@section('content')
    <div class="card page-card form-card">
        <div class="card-header">
            <a href="{{ url('mobil') }}" class="btn btn-light btn-back" aria-label="Kembali ke Data Mobil">
                <x-icon name="arrow-left" class="icon-sm" />
            </a>
            Edit Data Mobil
        </div>
        <div class="card-body">
            <form action="{{ url('mobil/' . $mobil->id) }}" method="POST" enctype="multipart/form-data">
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input id="tahun" class="form-control" type="number" name="tahun"
                                value="{{ $mobil->tahun ?? old('tahun') }}">
                            <span class="text-danger">{{ $errors->first('tahun') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-select" name="status">
                                <option value="tersedia" @selected('tersedia' == $mobil->status)>Tersedia</option>
                                <option value="disewa" @selected('disewa' == $mobil->status)>Disewa</option>
                                <option value="maintenance" @selected('maintenance' == $mobil->status)>Maintenance</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="harga_sewa">Harga Sewa (Rp)</label>
                    <input id="harga_sewa" class="form-control" type="number" step="1" name="harga_sewa"
                        value="{{ $mobil->harga_sewa ?? old('harga_sewa') }}">
                    <span class="text-danger">{{ $errors->first('harga_sewa') }}</span>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" class="form-control" name="deskripsi" rows="3">{{ $mobil->deskripsi ?? old('deskripsi') }}</textarea>
                    <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                </div>

                <div class="form-group">
                    <label>Gambar Mobil Saat Ini</label>
                    @if (!empty($mobil->gambar))
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            @foreach ($mobil->gambar as $path)
                                <div class="form-check text-center gambar-edit-item">
                                    <input class="form-check-input" type="checkbox" name="gambar_sisa[]"
                                        value="{{ $path }}" id="gambar-{{ Str::slug($path) }}" checked>
                                    <label class="form-check-label" for="gambar-{{ Str::slug($path) }}">
                                        <img src="{{ gambar_url($path) }}" alt="Gambar Mobil"
                                            class="gambar-edit-thumb" loading="lazy" decoding="async">
                                        <small class="d-block text-danger">Hapus</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="form-text text-muted">Hilangkan centang untuk menghapus gambar.</small>
                    @else
                        <p class="text-muted small">Belum ada gambar.</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="gambar">Tambah Gambar Baru</label>
                    <input id="gambar" class="form-control" type="file" name="gambar[]" multiple
                        accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="form-text text-muted">Format: JPG, PNG, WEBP. Maks 2MB per file. Bisa pilih lebih dari satu.</small>
                    <div id="gambarPreview" class="gambar-preview"></div>
                    <span class="text-danger">{{ $errors->first('gambar.*') ?: $errors->first('gambar') }}</span>
                </div>

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <x-icon name="check" class="icon-sm" />Update</button>
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
