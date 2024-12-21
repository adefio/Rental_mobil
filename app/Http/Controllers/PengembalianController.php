<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // Menampilkan semua data pengembalian
    public function index()
    {
        $pengembalian = Pengembalian::with('transaksi')->get();
        return view('pengembalian.index', compact('pengembalian'));
    }

    // Menampilkan form untuk menambah data pengembalian
    public function create()
    {
        $transaksi = Transaksi::all();
        return view('pengembalian.create', compact('transaksi'));
    }

    // Menyimpan data pengembalian yang baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'tanggal_pengembalian' => 'required|date',
            'deskripsi_kerusakan' => 'nullable|string',
            'biaya_kerusakan' => 'nullable|numeric',
        ]);

        // Mendapatkan data transaksi untuk mendapatkan tanggal seharusnya kembali
        $transaksi = Transaksi::findOrFail($request->transaksi_id);
        $tanggal_seharusnya_kembali = $transaksi->tanggal_pengembalian; // Asumsi ada kolom ini di transaksi

        // Hitung denda keterlambatan
        $pengembalian = new Pengembalian();
        $pengembalian->transaksi_id = $request->transaksi_id;
        $pengembalian->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pengembalian->denda_telat = $pengembalian->hitungDendaTelat($tanggal_seharusnya_kembali, $request->tanggal_pengembalian);
        $pengembalian->biaya_kerusakan = $request->biaya_kerusakan;
        $pengembalian->deskripsi_kerusakan = $request->deskripsi_kerusakan;

        // Simpan data pengembalian
        $pengembalian->save();

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit data pengembalian
    public function edit($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $transaksi = Transaksi::all();
        return view('pengembalian.edit', compact('pengembalian', 'transaksi'));
    }

    // Memperbarui data pengembalian
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'deskripsi_kerusakan' => 'nullable|string',
            'biaya_kerusakan' => 'nullable|numeric',
        ]);

        // Mendapatkan data pengembalian
        $pengembalian = Pengembalian::findOrFail($id);

        // Mendapatkan data transaksi untuk mendapatkan tanggal seharusnya kembali
        $transaksi = Transaksi::findOrFail($pengembalian->transaksi_id);
        $tanggal_seharusnya_kembali = $transaksi->tanggal_pengembalian;

        // Hitung denda keterlambatan
        $pengembalian->tanggal_pengembalian = $request->tanggal_pengembalian;
        $pengembalian->denda_telat = $pengembalian->hitungDendaTelat($tanggal_seharusnya_kembali, $request->tanggal_pengembalian);
        $pengembalian->biaya_kerusakan = $request->biaya_kerusakan;
        $pengembalian->deskripsi_kerusakan = $request->deskripsi_kerusakan;

        // Simpan perubahan data pengembalian
        $pengembalian->save();

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil diperbarui.');
    }

    // Menampilkan laporan pengembalian
    public function laporan()
    {
        $pengembalian = Pengembalian::with('transaksi')->get();
        return view('pengembalian.laporan', compact('pengembalian'));
    }
}
