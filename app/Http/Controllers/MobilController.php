<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    // Menampilkan daftar mobil dengan pagination
    public function index()
    {
        $judul = 'Laporan Data Mobil';
        $mobil = Mobil::paginate(10); // Paginate the data (10 items per page)
        return view('mobil_index', compact('mobil', 'judul')); // Mengirim data mobil dan judul ke view
    }

    // Menampilkan form untuk menambah mobil
    public function create()
    {
        $judul = 'Tambah Data Mobil'; // Menetapkan judul halaman
        return view('mobil_create', compact('judul')); // Mengirim data judul ke view
    }

    // Menyimpan data mobil baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|numeric|min:1990|max:' . date('Y'),
            'harga_sewa' => 'required|numeric|min:0',
        ]);

        // Menyimpan data mobil baru
        Mobil::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit data mobil
    public function edit($id)
    {
        $judul = 'Edit Data Mobil'; // Menetapkan judul halaman
        $mobil = Mobil::findOrFail($id); // Ambil data mobil berdasarkan ID
        return view('mobil_edit', compact('mobil', 'judul')); // Mengirim data mobil dan judul ke view
    }

    // Memperbarui data mobil
    public function update(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id); // Ambil data mobil berdasarkan ID

        // Validasi input
        $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|numeric|min:1990|max:' . date('Y'),
            'harga_sewa' => 'required|numeric|min:0',
        ]);

        // Update data mobil
        $mobil->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('mobil_index')->with('success', 'Mobil berhasil diperbarui.');
    }

    // Menampilkan laporan data mobil
    public function laporan()
    {
        $judul = 'Laporan Data Mobil';
        $mobil = Mobil::all(); // Ambil semua data mobil
        return view('mobil_laporan', compact('mobil', 'judul')); // Mengirim data mobil dan judul ke view
    }

    // Menghapus data mobil
    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id); // Ambil data mobil berdasarkan ID
        $mobil->delete(); // Hapus data mobil

        // Redirect kembali dengan pesan sukses
        return back()->with('pesan', 'Data mobil berhasil dihapus');
    }
}
