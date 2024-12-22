<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index()
    {
        $judul = 'Laporan Data Mobil';
        $mobil = Mobil::paginate(10);
        return view('mobil_index', compact('mobil', 'judul'));
    }

    public function create()
    {
        $judul = 'Tambah Data Mobil';
        return view('mobil_create', compact('judul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|numeric|min:1990|max:' . date('Y'),
            'harga_sewa' => 'required|numeric|min:0',
        ]);
        Mobil::create($request->all());
        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $judul = 'Edit Data Mobil';
        $mobil = Mobil::findOrFail($id);
        return view('mobil_edit', compact('mobil', 'judul'));
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);
        $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|numeric|min:1990|max:' . date('Y'),
            'harga_sewa' => 'required|numeric|min:0',
        ]);
        $mobil->update($request->all());
        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    public function laporan()
    {
        $judul = 'Laporan Data Mobil';
        $mobil = Mobil::all();
        return view('mobil_laporan', compact('mobil', 'judul'));
    }

    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id);
        $mobil->delete();
        return back()->with('pesan', 'Data mobil berhasil dihapus');
    }
}
