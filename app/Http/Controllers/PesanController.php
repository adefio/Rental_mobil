<?php

namespace App\Http\Controllers;

use App\Services\PesanService;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function __construct(protected PesanService $service)
    {
    }

    public function index()
    {
        $judul = 'Pesan Masuk';

        return view('pesan_index', array_merge(
            ['judul' => $judul],
            $this->service->paginatedData()
        ));
    }

    public function tandaiDibaca(Request $request, $id)
    {
        $dibaca = $request->boolean('dibaca', true);

        $this->service->tandaiDibaca((int) $id, $dibaca);

        return back()->with('pesan', $dibaca
            ? 'Pesan ditandai sudah dibaca.'
            : 'Pesan ditandai belum dibaca.');
    }

    public function destroy($id)
    {
        $this->service->delete((int) $id);

        return back()->with('pesan', 'Pesan berhasil dihapus.');
    }
}
