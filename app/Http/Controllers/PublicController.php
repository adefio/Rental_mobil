<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use App\Services\PublicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PublicController extends Controller
{
    public function __construct(
        protected PublicService $service,
        protected ImageService $imageService
    ) {
    }

    public function home()
    {
        return view('public.home', $this->service->homeData());
    }

    public function katalog(Request $request)
    {
        $mobil = $this->service->katalog($request->input('q'));

        return view('public.katalog', compact('mobil'));
    }

    public function detail(int $id)
    {
        $mobil = $this->service->detail($id);

        return view('public.detail', compact('mobil'));
    }

    public function tentang()
    {
        $data = $this->service->homeData();

        return view('public.tentang', $data);
    }

    public function kontak()
    {
        return view('public.kontak');
    }

    public function kirimPesan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'pesan' => 'required|string',
        ]);

        return back()->with('pesan', 'Terima kasih! Pesan Anda telah kami terima.');
    }

    public function booking(Request $request, int $id)
    {
        $data = $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        try {
            $transaksi = $this->service->createBooking($id, $data, $request->user());
        } catch (\DomainException $e) {
            return back()->with('pesan', $e->getMessage());
        }

        return redirect()->route('pesanan.saya')->with('pesan', 'Pemesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function pesananSaya(Request $request)
    {
        $pesanan = $this->service->pesananSaya($request->user());

        return view('public.pesanan', compact('pesanan'));
    }

    public function batalkanPesanan(Request $request, int $id)
    {
        $success = $this->service->batalkanPesanan($id, $request->user());

        return back()->with('pesan', $success
            ? 'Pemesanan berhasil dibatalkan.'
            : 'Pemesanan tidak dapat dibatalkan.');
    }

    public function pengaturanAkun()
    {
        $user = auth()->user();

        return view('public.pengaturan', ['user' => $user, 'pengguna' => $user->pengguna]);
    }

    public function updatePengaturanAkun(Request $request)
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

            $penggunaData['foto_profil'] = $this->imageService->processProfileImage($request->file('foto_profil'));

            if ($oldFoto && $oldFoto !== $penggunaData['foto_profil']) {
                Storage::disk('public')->delete($oldFoto);
            }
        }

        if (! empty($data['password'])) {
            $user->update(['password' => Hash::make($data['password'])]);
            $penggunaData['password'] = $user->fresh()->password;
        }

        $user->pengguna()->update($penggunaData);

        return back()->with('pesan', 'Pengaturan akun berhasil diperbarui.');
    }
}
