<?php

namespace App\Http\Controllers;

use App\Models\{Pengembalian, Transaksi};
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $judul = 'Laporan Data Pengembalian';
        $pengembalian = Pengembalian::with(['transaksi.pengguna', 'transaksi.mobil'])->paginate(10);
        return view('pengembalian_index', compact('pengembalian', 'judul'));
    }

    public function create()
    {
        $judul = 'Tambah Data Pengembalian';
        $list_transaksi = Transaksi::pluck('id', 'id'); // ID transaksi yang tersedia
        return view('pengembalian_create', compact('list_transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'denda_telat' => 'nullable|numeric|min:0',
            'biaya_kerusakan' => 'nullable|numeric|min:0',
            'deskripsi_kerusakan' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'required|date',
        ]);

        Pengembalian::create($request->all());
        return back()->with('pesan', 'Data pengembalian berhasil disimpan');
    }

    public function edit($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $list_transaksi = Transaksi::pluck('id', 'id');

        return view('pengembalian_edit', compact('pengembalian', 'list_transaksi'));
    }

    public function update(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'denda_telat' => 'nullable|numeric|min:0',
            'biaya_kerusakan' => 'nullable|numeric|min:0',
            'deskripsi_kerusakan' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $pengembalian->update($request->all());
        return back()->with('pesan', 'Data pengembalian berhasil diupdate');
    }

    public function laporan()
    {
        $judul = 'Laporan Data Pengembalian';
        $pengembalian = Pengembalian::with(['transaksi.pengguna', 'transaksi.mobil'])->get();
        return view('pengembalian_laporan', compact('pengembalian', 'judul'));
    }

    public function destroy($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();
        return back()->with('pesan', 'Data pengembalian berhasil dihapus');
    }
}
