<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Pengembalian</title>

    <!-- Scripts-->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <center>
                    <h2>{{ $judul }}</h2>
                </center>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>ID Transaksi</td>
                            <td>Denda Telat</td>
                            <td>Biaya Kerusakan</td>
                            <td>Deskripsi Kerusakan</td>
                            <td>Tanggal Pengembalian</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->transaksi_id }}</td>
                                <td>{{ $item->denda_telat }}</td>
                                <td>{{ $item->biaya_kerusakan }}</td>
                                <td>{{ $item->deskripsi_kerusakan }}</td>
                                <td>{{ $item->tanggal_pengembalian }}</td>
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
