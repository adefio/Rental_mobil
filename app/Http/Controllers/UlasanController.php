<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasan = Ulasan::with('transaksi')->get();
        return view('ulasan.index', compact('ulasan'));
    }

    public function create()
    {
        $transaksi = Transaksi::whereNotIn('id', function ($query) {
            $query->select('transaksi_id')->from('ulasan');
        })->get();

        return view('ulasan.create', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Ulasan::create($request->all());
        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $transaksi = Transaksi::all();
        return view('ulasan.edit', compact('ulasan', 'transaksi'));
    }

    public function update(Request $request, $id)
    {
        $ulasan = Ulasan::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        $ulasan->update($request->all());
        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil diperbarui.');
    }

    public function laporan()
    {
        $ulasan = Ulasan::with('transaksi')->get();
        return view('ulasan.laporan', compact('ulasan'));
    }
}
