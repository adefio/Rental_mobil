@extends('layouts.admin')

@section('title', 'Edit Transaksi')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Edit Transaksi</h1>
            <p class="admin-page-sub mb-0">Perbarui detail pesanan penyewaan mobil.</p>
        </div>
        <a href="{{ url('transaksi') }}" class="btn btn-light d-inline-flex align-items-center gap-2">
            <x-icon name="arrow-left" class="icon-sm" /> Kembali
        </a>
    </div>

    <form action="{{ url('transaksi/' . $transaksi->id) }}" method="POST">
        @method('PUT')
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
                                        value="{{ $transaksi->tanggal_pemesanan ?? old('tanggal_pemesanan') }}">
                                    <span class="text-danger">{{ $errors->first('tanggal_pemesanan') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input id="tanggal_mulai" class="form-control" type="date" name="tanggal_mulai"
                                        value="{{ $transaksi->tanggal_mulai ?? old('tanggal_mulai') }}"
                                        oninput="hitungTotal()">
                                    <span class="text-danger">{{ $errors->first('tanggal_mulai') }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input id="tanggal_selesai" class="form-control" type="date"
                                        name="tanggal_selesai" value="{{ $transaksi->tanggal_selesai ?? old('tanggal_selesai') }}"
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
                        <div class="form-group mb-0">
                            <label for="pengguna_id">Pelanggan</label>
                            <select id="pengguna_id" class="form-select" name="pengguna_id">
                                <option value="">Pilih Pengguna</option>
                                @foreach ($list_pengguna as $id => $nama)
                                    <option value="{{ $id }}"
                                        @selected($id == ($transaksi->pengguna_id ?? old('pengguna_id')))>{{ $nama }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('pengguna_id') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card page-card mb-4">
                    <div class="card-header d-flex align-items-center gap-2">
                        <span class="profile-section-icon"><x-icon name="car" class="icon-sm" /></span>
                        <span>Mobil</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group mb-0">
                            <label for="mobil_id">Pilih Mobil</label>
                            <select id="mobil_id" class="form-select" name="mobil_id" onchange="hitungTotal()">
                                <option value="">Pilih Mobil</option>
                                @foreach ($list_mobil as $id => $nama)
                                    <option value="{{ $id }}"
                                        @selected($id == ($transaksi->mobil_id ?? old('mobil_id')))>{{ $nama }}
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
                        <div class="form-group">
                            <label for="total_harga">Total Harga (Rp)</label>
                            <input id="total_harga" class="form-control form-control-lg fw-bold text-end" type="number"
                                min="0" name="total_harga"
                                value="{{ $transaksi->total_harga ?? old('total_harga') }}" placeholder="0">
                            <span class="text-danger">{{ $errors->first('total_harga') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="status_pembayaran">Status Pembayaran</label>
                            <select id="status_pembayaran" class="form-select" name="status_pembayaran">
                                <option value="pending"
                                    @selected(($transaksi->status_pembayaran ?? old('status_pembayaran')) == 'pending')>Pending</option>
                                <option value="lunas"
                                    @selected(($transaksi->status_pembayaran ?? old('status_pembayaran')) == 'lunas')>Lunas</option>
                                <option value="batal"
                                    @selected(($transaksi->status_pembayaran ?? old('status_pembayaran')) == 'batal')>Batal</option>
                            </select>
                            <span class="text-danger">{{ $errors->first('status_pembayaran') }}</span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2">
                                <x-icon name="check" class="icon-sm" />Simpan Perubahan
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
            if (total > 0) {
                document.getElementById('total_harga').value = total.toFixed(0);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            hitungTotal();
        });
    </script>
@endsection
