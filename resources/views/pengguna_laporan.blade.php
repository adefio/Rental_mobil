<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Pengguna</title>

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
                            <td>id</td>
                            <td>Nama Pengguna</td>
                            <td>Email</td>
                            <td>Role</td>
                            <td>No HP</td>
                            <td>Alamat</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengguna as $a)
                            <tr>
                                <td>{{ $a->id }}</td>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->email }}</td>
                                <td>{{ $a->role }}</td>
                                <td>{{ $a->no_telepon }}</td>
                                <td>{{ $a->alamat }}</td>
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
