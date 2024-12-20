<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenance = Maintenance::with('transaksi')->get();
        return view('maintenance.index', compact('maintenance'));
    }

    public function create()
    {
        $transaksi = Transaksi::all();
        return view('maintenance.create', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'denda_telat' => 'nullable|numeric',
            'biaya_kerusakan' => 'nullable|numeric',
            'deskripsi_kerusakan' => 'nullable|string',
        ]);

        Maintenance::create($request->all());
        return redirect()->route('maintenance.index')->with('success', 'Data maintenance berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $transaksi = Transaksi::all();
        return view('maintenance.edit', compact('maintenance', 'transaksi'));
    }

    public function update(Request $request, $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $request->validate([
            'denda_telat' => 'nullable|numeric',
            'biaya_kerusakan' => 'nullable|numeric',
            'deskripsi_kerusakan' => 'nullable|string',
        ]);

        $maintenance->update($request->all());
        return redirect()->route('maintenance.index')->with('success', 'Data maintenance berhasil diperbarui.');
    }

    public function laporan()
    {
        $maintenance = Maintenance::with('transaksi')->get();
        return view('maintenance.laporan', compact('maintenance'));
    }
}
