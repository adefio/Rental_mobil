@extends('layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
    <div class="admin-page-header d-flex flex-wrap align-items-end justify-content-between gap-3">
        <div>
            <h1 class="admin-page-title mb-1">Pesan Masuk</h1>
            <p class="admin-page-sub mb-0">
                @if ($jumlah_belum_dibaca > 0)
                    {{ $jumlah_belum_dibaca }} pesan belum dibaca dari form kontak publik.
                @else
                    Semua pesan sudah dibaca.
                @endif
            </p>
        </div>
    </div>

    <div class="card page-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:60px;">Status</th>
                            <th>Pengirim</th>
                            <th>Pesan</th>
                            <th>Tanggal</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesan as $item)
                            <tr class="{{ $item->dibaca ? 'text-muted' : 'fw-semibold' }}">
                                <td>
                                    @if ($item->dibaca)
                                        <span class="badge bg-secondary badge-status">Dibaca</span>
                                    @else
                                        <span class="badge bg-warning text-dark badge-status">Baru</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $item->nama }}</div>
                                    <small class="text-muted">{{ $item->email }}</small>
                                    @if ($item->no_telepon)
                                        <small class="text-muted d-block">{{ $item->no_telepon }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->subjek)
                                        <div class="fw-semibold">{{ $item->subjek }}</div>
                                    @endif
                                    <div class="pesan-truncate">{{ $item->pesan }}</div>
                                </td>
                                <td class="text-nowrap">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</td>
                                <td class="text-end text-nowrap">
                                    <form action="{{ url('pesan/' . $item->id . '/tandai') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" name="dibaca" value="{{ $item->dibaca ? '0' : '1' }}"
                                            class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"
                                            aria-label="Ubah status dibaca">
                                            <x-icon name="check-circle" class="icon-sm" />
                                            {{ $item->dibaca ? 'Belum dibaca' : 'Tandai dibaca' }}
                                        </button>
                                    </form>
                                    <form action="{{ url('pesan/' . $item->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Hapus pesan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1"
                                            aria-label="Hapus pesan">
                                            <x-icon name="trash" class="icon-sm" />
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">Belum ada pesan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $pesan->links() }}
        </div>
    </div>
@endsection
