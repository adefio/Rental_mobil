<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index()
    {
        $mobil = Mobil::all();
        return view('mobil.index', compact('mobil'));
    }

    public function create()
    {
        return view('mobil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil' => 'required|string',
            'merk' => 'required|string',
            'tahun' => 'required|numeric|min:1990|max:' . date('Y'),
            'harga_sewa' => 'required|numeric',
        ]);

        Mobil::create($request->all());
        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('mobil.edit', compact('mobil'));
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);

        $request->validate([
            'nama_mobil' => 'required|string',
            'merk' => 'required|string',
            'tahun' => 'required|numeric|min:1990|max:' . date('Y'),
            'harga_sewa' => 'required|numeric',
        ]);

        $mobil->update($request->all());
        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    public function laporan()
    {
        $mobil = Mobil::all();
        return view('mobil.laporan', compact('mobil'));
    }
}
