<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $judul = 'Laporan Data Pengguna';
        $pengguna = Pengguna::paginate(10);
        return view('pengguna_index', compact('pengguna', 'judul'));
    }


    public function create()
    {
        $pengguna['judul'] = 'Laporan Data Pengguna';
        return view('pengguna_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:pelanggan,admin',
        ]);

        Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        return back()->with('pesan', 'Data sudah Disimpan');
    }

    public function edit($id)
    {
        $pengguna['judul'] = 'Laporan Data Pengguna';
        $pengguna = Pengguna::findOrFail($id);
        return view('pengguna_edit', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $pengguna = Pengguna::findOrFail($id);

        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:pengguna,email,' . $pengguna->id,
            'role' => 'required|in:pelanggan,admin',
        ]);

        $pengguna->update($request->all());
        return back()->with('pesan', 'Data sudah Disimpan');
    }

    public function laporan()
    {
        $judul = 'Laporan Data Pengguna';
        $pengguna = Pengguna::all();
        return view('pengguna_laporan', compact('pengguna', 'judul'));
    }


    public function destroy($id)
    {
        $pengguna = Pengguna::findOrFail($id);
        $pengguna->delete();
        return back()->with('pesan', 'Data pengguna berhasil dihapus');
    }
}
