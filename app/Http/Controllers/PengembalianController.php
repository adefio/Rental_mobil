<?php

namespace App\Http\Controllers;

use App\Services\PengembalianService;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function __construct(protected PengembalianService $service)
    {
    }

    public function index()
    {
        return view('pengembalian_index', array_merge(
            ['judul' => 'Laporan Data Pengembalian'],
            $this->service->paginatedData()
        ));
    }

    public function create()
    {
        $judul = 'Tambah Data Pengembalian';

        return view('pengembalian_create', array_merge(
            ['judul' => $judul],
            $this->service->createData()
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'denda_telat' => 'nullable|integer|min:0',
            'biaya_kerusakan' => 'nullable|integer|min:0',
            'deskripsi_kerusakan' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $this->service->store($data);

        return back()->with('pesan', 'Data pengembalian berhasil disimpan');
    }

    public function edit($id)
    {
        $judul = 'Edit Data Pengembalian';

        return view('pengembalian_edit', array_merge(
            ['judul' => $judul],
            $this->service->editData($id)
        ));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'transaksi_id' => 'required|exists:transaksi,id',
            'denda_telat' => 'nullable|integer|min:0',
            'biaya_kerusakan' => 'nullable|integer|min:0',
            'deskripsi_kerusakan' => 'nullable|string|max:255',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $this->service->update($id, $data);

        return back()->with('pesan', 'Data pengembalian berhasil diupdate');
    }

    public function laporan()
    {
        $judul = 'Laporan Data Pengembalian';

        return view('pengembalian_laporan', [
            'judul' => $judul,
            'pengembalian' => $this->service->laporanData(),
        ]);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return back()->with('pesan', 'Data pengembalian berhasil dihapus');
    }
}
