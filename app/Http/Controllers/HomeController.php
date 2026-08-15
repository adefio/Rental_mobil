<?php

namespace App\Http\Controllers;

use App\Services\MobilService;
use App\Services\PenggunaService;
use App\Services\TransaksiService;
use App\Services\PengembalianService;
use App\Services\ImageService;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct(
        protected MobilService $mobilService,
        protected PenggunaService $penggunaService,
        protected TransaksiService $transaksiService,
        protected PengembalianService $pengembalianService
    ) {
        $this->middleware('auth');
    }

    public function index()
    {
        $mobilRepo = app(\App\Contracts\Repositories\MobilRepositoryInterface::class);
        $transaksiRepo = app(\App\Contracts\Repositories\TransaksiRepositoryInterface::class);
        $pengembalianRepo = app(\App\Contracts\Repositories\PengembalianRepositoryInterface::class);
        $penggunaRepo = app(\App\Contracts\Repositories\PenggunaRepositoryInterface::class);

        $stats = [
            'mobil' => $mobilRepo->count(),
            'pengguna' => $penggunaRepo->count(),
            'transaksi' => $transaksiRepo->count(),
            'pendapatan' => $transaksiRepo->sumWhereIn('status_pembayaran', ['lunas', 'selesai'], 'total_harga'),
        ];

        $pendapatanHarian = $this->buildPendapatanSeries(
            $transaksiRepo->pendapatanLunasGrouped(now()->subDays(6)->format('Y-m-d'), '%Y-%m-%d'),
            'day',
            7
        );
        $pendapatanBulanan = $this->buildPendapatanSeries(
            $transaksiRepo->pendapatanLunasGrouped(now()->subMonths(5)->startOfMonth()->format('Y-m-d'), '%Y-%m'),
            'month',
            6
        );
        $pendapatanTahunan = $this->buildPendapatanSeries(
            $transaksiRepo->pendapatanLunasGrouped(now()->subYears(4)->format('Y-m-d'), '%Y'),
            'year',
            5
        );

        return view('home', [
            'stats' => $stats,
            'pendapatan_series' => [
                'harian' => $pendapatanHarian,
                'bulanan' => $pendapatanBulanan,
                'tahunan' => $pendapatanTahunan,
            ],
            'transaksi_terbaru' => $this->transaksiService->terbaru(),
            'mobil_populer' => $this->mobilService->palingPopuler(),
        ]);
    }

    protected function buildPendapatanSeries(array $raw, string $unit, int $count): array
    {
        \Carbon\Carbon::setLocale('id');

        $series = [];
        for ($i = $count - 1; $i >= 0; $i--) {
            $date = match ($unit) {
                'day' => now()->subDays($i),
                'month' => now()->subMonthsNoOverflow($i),
                'year' => now()->subYearsNoOverflow($i),
            };

            $key = match ($unit) {
                'day' => $date->format('Y-m-d'),
                'month' => $date->format('Y-m'),
                'year' => $date->format('Y'),
            };

            $label = match ($unit) {
                'day' => $date->translatedFormat('d M'),
                'month' => $date->translatedFormat('M Y'),
                'year' => $date->translatedFormat('Y'),
            };

            $series[] = [
                'label' => $label,
                'total' => $raw[$key] ?? 0,
            ];
        }

        return $series;
    }

    public function profil()
    {
        $user = auth()->user();

        return view('admin.profil', ['user' => $user, 'pengguna' => $user->pengguna]);
    }

    public function updateProfil(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240|dimensions:min_width=400,min_height=400',
        ], [
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'foto_profil.max' => 'Ukuran foto maksimal 10 MB.',
            'foto_profil.dimensions' => 'Foto terlalu kecil. Minimal resolusi 400x400 piksel agar tidak pecah saat diperbesar.',
        ]);

        $user->update([
            'name' => $data['nama'],
            'email' => $data['email'],
        ]);

        $penggunaData = [
            'nama' => $data['nama'],
            'email' => $data['email'],
            'no_telepon' => $data['no_telepon'] ?? null,
            'alamat' => $data['alamat'] ?? null,
        ];

        if ($request->hasFile('foto_profil')) {
            $oldFoto = optional($user->pengguna)->foto_profil;

            $penggunaData['foto_profil'] = app(ImageService::class)->processProfileImage($request->file('foto_profil'));

            if ($oldFoto && $oldFoto !== $penggunaData['foto_profil']) {
                Storage::disk('public')->delete($oldFoto);
            }
        }

        if (! empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
            $penggunaData['password'] = $user->fresh()->password;
        }

        $user->pengguna()->updateOrCreate(['user_id' => $user->id], $penggunaData);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function bantuan()
    {
        return view('admin.bantuan');
    }

    public function pengaturan()
    {
        $settings = app(SettingsService::class)->all();

        return view('admin.pengaturan', ['settings' => $settings]);
    }

    public function updatePengaturan(Request $request)
    {
        $data = $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:30',
            'email_kontak' => 'nullable|string|email|max:255',
            'tarif_denda_per_hari' => 'nullable|numeric|min:0',
            'jam_operasional' => 'nullable|string|max:100',
        ], [
            'nama_aplikasi.required' => 'Nama aplikasi wajib diisi.',
            'email_kontak.email' => 'Format email tidak valid.',
        ]);

        app(SettingsService::class)->update($data);

        return back()->with('success', 'Pengaturan aplikasi berhasil disimpan.');
    }
}
