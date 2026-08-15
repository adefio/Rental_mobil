<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use App\Services\MobilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function __construct(
        protected MobilService $service,
        protected ImageService $imageService
    ) {}

    public function index()
    {
        return view('mobil_index', array_merge(
            ['judul' => 'Laporan Data Mobil'],
            $this->service->paginatedData()
        ));
    }

    public function create()
    {
        $judul = 'Tambah Data Mobil';

        return view('mobil_create', compact('judul'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|numeric|min:1990|max:'.date('Y'),
            'harga_sewa' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|in:tersedia,disewa,maintenance',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240|dimensions:min_width=1200,min_height=675',
        ], [
            'gambar.*.image' => 'File harus berupa gambar.',
            'gambar.*.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'gambar.*.max' => 'Ukuran gambar maksimal 10 MB.',
            'gambar.*.dimensions' => 'Gambar terlalu kecil. Minimal resolusi 1200x675 piksel agar tidak pecah saat diperbesar.',
        ]);

        $data['status'] = $data['status'] ?? 'tersedia';
        $data['gambar'] = $this->simpanGambar($request);

        $this->service->store($data);

        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $judul = 'Edit Data Mobil';
        $mobil = $this->service->findForEdit($id);

        return view('mobil_edit', compact('mobil', 'judul'));
    }

    public function update(Request $request, $id)
    {
        $mobil = $this->service->findForEdit($id);

        $data = $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'tahun' => 'required|numeric|min:1990|max:'.date('Y'),
            'harga_sewa' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|in:tersedia,disewa,maintenance',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,webp|max:10240|dimensions:min_width=1200,min_height=675',
        ], [
            'gambar.*.image' => 'File harus berupa gambar.',
            'gambar.*.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'gambar.*.max' => 'Ukuran gambar maksimal 10 MB.',
            'gambar.*.dimensions' => 'Gambar terlalu kecil. Minimal resolusi 1200x675 piksel agar tidak pecah saat diperbesar.',
        ]);

        $data['status'] = $data['status'] ?? 'tersedia';

        $gambarBaru = $this->simpanGambar($request);
        $gambarSisa = array_values(array_filter((array) $request->input('gambar_sisa', [])));
        $data['gambar'] = array_values(array_unique(array_merge($gambarSisa, $gambarBaru)));

        $this->hapusGambarTerbuang($mobil->gambar ?? [], $data['gambar']);

        $this->service->update($id, $data);

        return redirect()->route('mobil.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    protected function simpanGambar(Request $request): array
    {
        $paths = [];

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $paths[] = $this->imageService->processCarImage($file);
            }
        }

        return $paths;
    }

    protected function hapusGambarTerbuang(array $lama, array $baru): void
    {
        foreach (array_diff($lama, $baru) as $path) {
            Storage::disk(config('filesystems.storage_disk'))->delete($path);
        }
    }

    public function laporan()
    {
        $judul = 'Laporan Data Mobil';

        return view('mobil_laporan', [
            'judul' => $judul,
            'mobil' => $this->service->laporanData(),
        ]);
    }

    public function destroy($id)
    {
        $mobil = $this->service->findForEdit($id);

        foreach ($mobil->gambar ?? [] as $path) {
            Storage::disk(config('filesystems.storage_disk'))->delete($path);
        }

        $this->service->delete($id);

        return back()->with('pesan', 'Data mobil berhasil dihapus');
    }
}
