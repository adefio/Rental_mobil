<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $judul }}</title>

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
                            <td>Nama Mobil</td>
                            <td>Merk</td>
                            <td>Tahun</td>
                            <td>Harga Sewa</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mobil as $m)
                            <tr>
                                <td>{{ $m->id }}</td>
                                <td>{{ $m->nama_mobil }}</td>
                                <td>{{ $m->merk }}</td>
                                <td>{{ $m->tahun }}</td>
                                <td>Rp {{ number_format($m->harga_sewa, 0, ',', '.') }}</td> <!-- Format price -->
                                <td>{{ $m->status }}</td>
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
