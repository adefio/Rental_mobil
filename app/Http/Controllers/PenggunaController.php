<?php

namespace App\Http\Controllers;

use App\Services\PenggunaService;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function __construct(protected PenggunaService $service)
    {
    }

    public function index()
    {
        return view('pengguna_index', array_merge(
            ['judul' => 'Laporan Data Pengguna'],
            $this->service->paginatedData()
        ));
    }

    public function create()
    {
        $judul = 'Tambah Data Pengguna';

        return view('pengguna_create', compact('judul'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|string|min:6',
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        $data['role'] = 'pelanggan';

        $this->service->store($data);

        log_aktivitas('menambah', 'Pengguna "' . $data['nama'] . '" ditambahkan');

        return back()->with('pesan', 'Data sudah Disimpan');
    }

    public function edit($id)
    {
        $judul = 'Edit Data Pengguna';
        $pengguna = $this->service->findForEdit($id);

        $this->ensurePelanggan($pengguna);

        return view('pengguna_edit', compact('pengguna', 'judul'));
    }

    public function update(Request $request, $id)
    {
        $pengguna = $this->service->findForEdit($id);

        $this->ensurePelanggan($pengguna);

        $data = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email|unique:pengguna,email,' . $id,
            'no_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        $data['role'] = 'pelanggan';

        $this->service->update($id, $data);

        log_aktivitas('mengubah', 'Pengguna "' . $data['nama'] . '" diperbarui');

        return back()->with('pesan', 'Data sudah Disimpan');
    }

    public function laporan()
    {
        $judul = 'Laporan Data Pengguna';

        return view('pengguna_laporan', [
            'judul' => $judul,
            'pengguna' => $this->service->laporanData(),
        ]);
    }

    public function destroy($id)
    {
        $pengguna = $this->service->findForEdit($id);

        $this->ensurePelanggan($pengguna);

        log_aktivitas('menghapus', 'Pengguna "' . ($pengguna->nama ?? '') . '" dihapus');

        $this->service->delete($id);

        return back()->with('pesan', 'Data pengguna berhasil dihapus');
    }

    protected function ensurePelanggan($pengguna)
    {
        if ($pengguna->role === 'admin') {
            abort(403, 'Akun admin tidak dikelola dari halaman ini. Ubah melalui Pengaturan Akun.');
        }
    }
}
