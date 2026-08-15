@extends('layouts.admin')

@section('title', 'Terima Pesanan')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Terima Pesanan</h1>
            <p class="admin-page-sub mb-0">Catat pesanan baru dari pelanggan terdaftar maupun walk-in / offline.</p>
        </div>
        <a href="{{ url('transaksi') }}" class="btn btn-light d-inline-flex align-items-center gap-2">
            <x-icon name="arrow-left" class="icon-sm" /> Kembali
        </a>
    </div>

    <form action="{{ url('transaksi') }}" method="POST">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="calendar" class="icon-sm" /></span>
                        <span>Periode Sewa</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
                                    <input id="tanggal_pemesanan" class="form-control" type="date"
                                        name="tanggal_pemesanan"
                                        value="{{ old('tanggal_pemesanan', date('Y-m-d')) }}">
                                    <span class="text-danger">{{ $errors->first('tanggal_pemesanan') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input id="tanggal_mulai" class="form-control" type="date" name="tanggal_mulai"
                                        value="{{ old('tanggal_mulai') }}" oninput="hitungTotal()">
                                    <span class="text-danger">{{ $errors->first('tanggal_mulai') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input id="tanggal_selesai" class="form-control" type="date"
                                        name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                        oninput="hitungTotal()">
                                    <span class="text-danger">{{ $errors->first('tanggal_selesai') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="user" class="icon-sm" /></span>
                        <span>Data Pelanggan</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-check-label fw-semibold mb-2 d-block">Jenis Pelanggan</label>
                                <div class="d-flex gap-3 flex-wrap">
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_pelanggan"
                                            value="terdaftar" @checked(old('jenis_pelanggan', 'terdaftar') === 'terdaftar')
                                            onchange="setJenisPelanggan(this.value)">
                                        <span class="form-check-label">Pelanggan Terdaftar</span>
                                    </label>
                                    <label class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_pelanggan"
                                            value="baru" @checked(old('jenis_pelanggan') === 'baru')
                                            onchange="setJenisPelanggan(this.value)">
                                        <span class="form-check-label">Pelanggan Baru (Walk-in)</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="panel-terdaftar">
                            <div class="form-group">
                                <label for="pengguna_id">Pilih Pelanggan</label>
                                <select id="pengguna_id" class="form-select" name="pengguna_id">
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($list_pengguna as $id => $nama)
                                        <option value="{{ $id }}" @selected($id == old('pengguna_id'))>{{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('pengguna_id') }}</span>
                            </div>
                        </div>

                        <div id="panel-baru" class="d-none">
                            <div class="alert profile-security-note d-flex align-items-start gap-2 mb-3" role="alert"
                                style="background:#eef2ff;border-color:#c7d2fe;color:#4338ca;">
                                <x-icon name="info" class="icon-sm mt-1" />
                                <div>
                                    <strong>Pelanggan baru.</strong>
                                    Data akan otomatis dicatat sebagai pelanggan. Jika email cocok dengan
                                    pelanggan terdaftar, pesanan akan otomatis tersambung ke akunnya
                                    (muncul di "Pesanan Saya").
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="nama_baru">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input id="nama_baru" class="form-control" type="text" name="nama_baru"
                                            value="{{ old('nama_baru') }}" placeholder="Nama pelanggan">
                                        <span class="text-danger">{{ $errors->first('nama_baru') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="email_baru">Email <span class="text-muted">(opsional)</span></label>
                                        <input id="email_baru" class="form-control" type="email" name="email_baru"
                                            value="{{ old('email_baru') }}" placeholder="nama@email.com">
                                        <span class="text-danger">{{ $errors->first('email_baru') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="no_telepon_baru">No. Telepon</label>
                                        <input id="no_telepon_baru" class="form-control" type="text"
                                            name="no_telepon_baru" value="{{ old('no_telepon_baru') }}"
                                            placeholder="08xx-xxxx-xxxx">
                                        <span class="text-danger">{{ $errors->first('no_telepon_baru') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="alamat_baru">Alamat</label>
                                        <input id="alamat_baru" class="form-control" type="text" name="alamat_baru"
                                            value="{{ old('alamat_baru') }}" placeholder="Alamat lengkap">
                                        <span class="text-danger">{{ $errors->first('alamat_baru') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="car" class="icon-sm" /></span>
                        <span>Mobil</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="mobil_id">Pilih Mobil <span class="text-danger">*</span></label>
                            <select id="mobil_id" class="form-select" name="mobil_id" onchange="hitungTotal()">
                                <option value="">-- Pilih Mobil --</option>
                                @foreach ($list_mobil as $id => $nama)
                                    <option value="{{ $id }}" @selected($id == old('mobil_id'))>{{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('mobil_id') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card page-card mb-4 position-sticky" style="top:90px;">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="wallet" class="icon-sm" /></span>
                        <span>Ringkasan & Pembayaran</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Harga Sewa / Hari</span>
                            <span class="fw-bold" id="summary-harga">-</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Lama Sewa</span>
                            <span class="fw-bold" id="summary-hari">-</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Total Harga (Rp)</span>
                        </div>
                        <div class="form-group">
                            <input id="total_harga" class="form-control form-control-lg fw-bold text-end" type="number"
                                min="0" name="total_harga" value="{{ old('total_harga') }}" placeholder="0">
                            <span class="text-danger">{{ $errors->first('total_harga') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="status_pembayaran">Status Pembayaran</label>
                            <select id="status_pembayaran" class="form-select" name="status_pembayaran">
                                <option value="pending" @selected(old('status_pembayaran') == 'pending')>Pending</option>
                                <option value="lunas" @selected(old('status_pembayaran') == 'lunas')>Lunas</option>
                                <option value="batal" @selected(old('status_pembayaran') == 'batal')>Batal</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('status_pembayaran') }}</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2">
                                <x-icon name="check" class="icon-sm" />Terima Pesanan
                            </button>
                            <a href="{{ url('transaksi') }}" class="btn btn-light">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        const mobilPrices = @json($mobil_prices);

        function setJenisPelanggan(value) {
            const terdaftar = document.getElementById('panel-terdaftar');
            const baru = document.getElementById('panel-baru');
            if (terdaftar) terdaftar.classList.toggle('d-none', value !== 'terdaftar');
            if (baru) baru.classList.toggle('d-none', value !== 'baru');
        }

        function hitungTotal() {
            const mobilId = document.getElementById('mobil_id').value;
            const mulai = document.getElementById('tanggal_mulai').value;
            const selesai = document.getElementById('tanggal_selesai').value;

            const harga = mobilId && mobilPrices[mobilId] ? Number(mobilPrices[mobilId]) : 0;

            let hari = 0;
            if (mulai && selesai) {
                const diff = (new Date(selesai) - new Date(mulai)) / 86400000;
                hari = diff >= 0 ? diff + 1 : 0;
            }

            const total = harga * Math.max(1, hari);

            document.getElementById('summary-harga').textContent = harga
                ? 'Rp ' + harga.toLocaleString('id-ID')
                : '-';
            document.getElementById('summary-hari').textContent = hari ? hari + ' hari' : '-';
            document.getElementById('total_harga').value = total ? total.toFixed(0) : '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            const selected = document.querySelector('input[name="jenis_pelanggan"]:checked');
            if (selected) setJenisPelanggan(selected.value);
            hitungTotal();
        });
    </script>
@endsection
