<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Transaksi</title>

    <!-- Scripts-->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        .harga-display {
            display: inline-block;
            text-align: right;
            min-width: 100px;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h2 class="text-center">{{ $judul }}</h2>

                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Tanggal Pemesanan</td>
                            <td>Tanggal Mulai</td>
                            <td>Tanggal Selesai</td>
                            <td>Nama Pengguna</td>
                            <td>Nama Mobil</td>
                            <td>Total Harga</td>
                            <td>Status Pembayaran</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $t)
                            <tr>
                                <td>{{ $t->id }}</td>
                                <td>{{ date('d M Y', strtotime($t->tanggal_pemesanan)) }}</td>
                                <td>{{ date('d M Y', strtotime($t->tanggal_mulai)) }}</td>
                                <td>{{ date('d M Y', strtotime($t->tanggal_selesai)) }}</td>
                                <td>{{ $t->pengguna->nama }}</td>
                                <td>{{ $t->mobil->nama_mobil }}</td>
                                <td>Rp <span
                                        class="harga-display">{{ number_format($t->total_harga, 0, ',', '.') }}</span>
                                </td>
                                <td>{{ ucfirst($t->status_pembayaran) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h5>Mengetahui</h5>
                <br>
                <br>
                <br>
                <h5>Admin</h5>
            </div>
        </div>
    </div>
</body>

</html>
