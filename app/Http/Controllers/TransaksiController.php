<?php

namespace App\Http\Controllers;

use App\Services\TransaksiService;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function __construct(protected TransaksiService $service)
    {
    }

    public function index()
    {
        return view('transaksi_index', array_merge(
            ['judul' => 'Laporan Data Transaksi'],
            $this->service->paginatedData()
        ));
    }

    public function create()
    {
        $judul = 'Tambah Data Transaksi';

        return view('transaksi_create', array_merge(
            ['judul' => $judul],
            $this->service->createData()
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pengguna_id' => 'required_if:jenis_pelanggan,terdaftar|nullable|exists:pengguna,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_pemesanan' => 'required|date',
            'tanggal_mulai' => 'required|date|after_or_equal:tanggal_pemesanan',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:pending,lunas,batal',
            'jenis_pelanggan' => 'required|in:terdaftar,baru',
            'nama_baru' => 'required_if:jenis_pelanggan,baru|nullable|string|max:255',
            'email_baru' => 'nullable|string|email|max:255|unique:pengguna,email',
            'no_telepon_baru' => 'nullable|string|max:20',
            'alamat_baru' => 'nullable|string|max:255',
        ], [
            'pengguna_id.required_if' => 'Pilih pelanggan terdaftar terlebih dahulu.',
            'nama_baru.required_if' => 'Nama pelanggan baru wajib diisi.',
            'email_baru.unique' => 'Email tersebut sudah terdaftar. Pilih jenis "Pelanggan Terdaftar" atau gunakan email lain.',
        ]);

        $this->service->store($data);

        return back()->with('pesan', 'Pesanan berhasil diterima');
    }

    public function edit($id)
    {
        $judul = 'Edit Data Transaksi';

        return view('transaksi_edit', array_merge(
            ['judul' => $judul],
            $this->service->editData($id)
        ));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id',
            'mobil_id' => 'required|exists:mobil,id',
            'tanggal_pemesanan' => 'required|date',
            'tanggal_mulai' => 'required|date|after_or_equal:tanggal_pemesanan',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'total_harga' => 'required|numeric|min:0',
            'status_pembayaran' => 'required|in:pending,lunas,batal',
        ]);

        $this->service->update($id, $data);

        return back()->with('pesan', 'Data transaksi berhasil diupdate');
    }

    public function laporan()
    {
        $judul = 'Laporan Data Transaksi';

        return view('transaksi_laporan', [
            'judul' => $judul,
            'transaksi' => $this->service->laporanData(),
        ]);
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        return back()->with('pesan', 'Data transaksi berhasil dihapus');
    }
}
