<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Mobil;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['pengguna', 'mobil'])->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $pengguna = Pengguna::all();
        $mobil = Mobil::where('status', 'tersedia')->get();
        return view('transaksi.create', compact('pengguna', 'mobil'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_pemesanan' => 'required|date',
            'tanggal_mulai' => 'required|date|after_or_equal:tanggal_pemesanan',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'total_harga' => 'required|numeric',
        ]);

        $mobil = Mobil::findOrFail($request->mobil_id);
        $mobil->update(['status' => 'disewa']);

        Transaksi::create($request->all());
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $mobil = Mobil::all();
        $pengguna = Pengguna::all();
        return view('transaksi.edit', compact('transaksi', 'mobil', 'pengguna'));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_pemesanan' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'total_harga' => 'required|numeric',
        ]);

        $transaksi->update($request->all());
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function laporan()
    {
        $transaksi = Transaksi::with(['pengguna', 'mobil'])->get();
        return view('transaksi.laporan', compact('transaksi'));
    }
}
