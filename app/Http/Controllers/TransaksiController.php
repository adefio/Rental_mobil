<?php

namespace App\Http\Controllers;

use App\Models\{Transaksi, Pengguna, Mobil};
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $judul = 'Laporan Data Transaksi';
        $transaksi = Transaksi::with(['pengguna', 'mobil'])->paginate(10); // Paginate the data (10 items per page)
        return view('transaksi_index', compact('transaksi', 'judul'));
    }

    public function create()
    {
        $judul = 'Tambah Data Transaksi';

        // Mengambil data pengguna dan mobil untuk dropdown
        $list_pengguna = Pengguna::pluck('nama', 'id'); // Mengambil nama pengguna dan id
        $list_mobil = Mobil::pluck('nama_mobil', 'id'); // Mengambil nama mobil dan id

        return view('transaksi_create', compact('judul', 'list_pengguna', 'list_mobil'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_pemesanan' => 'required|date',
            'tanggal_mulai' => 'required|date|after_or_equal:tanggal_pemesanan',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:pending,lunas,batal',
        ]);

        Transaksi::create($request->all());
        return back()->with('pesan', 'Data transaksi berhasil disimpan');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::find($id);
        $list_pengguna = Pengguna::pluck('nama', 'id');  // Assuming 'nama' is the name field and 'id' is the ID
        $list_mobil = Mobil::pluck('nama_mobil', 'id');  // Similar for mobil

        return view('transaksi_edit', compact('transaksi', 'list_pengguna', 'list_mobil'));
    }


    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_pemesanan' => 'required|date',
            'tanggal_mulai' => 'required|date|after_or_equal:tanggal_pemesanan',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:pending,lunas,batal',
        ]);

        $transaksi->update($request->all());
        return back()->with('pesan', 'Data transaksi berhasil diupdate');
    }

    public function laporan()
    {
        $judul = 'Laporan Data Transaksi';
        $transaksi = Transaksi::with(['pengguna', 'mobil'])->get();
        return view('transaksi_laporan', compact('transaksi', 'judul'));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return back()->with('pesan', 'Data transaksi berhasil dihapus');
    }
}
