@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Workspace · Tugas</span>
            <h1 class="hero-title">Data <span class="accent">Tugas</span></h1>
            <p class="hero-sub">Kelola tugas, guru pemberi tugas, tanggal, dan lampirannya.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('tugas.add') }}" class="btn btn--primary">Tambah Tugas</a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            @if (session('success'))
                <p role="status">{{ session('success') }}</p>
            @endif

            <form action="{{ route('tugas') }}" method="GET" class="data-toolbar">
                <div class="data-toolbar-left">
                    <div class="input-icon" style="flex:1;max-width:420px">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input class="input" type="search" name="search"
                            placeholder="Cari judul, deskripsi, guru, atau tanggal..." value="{{ $search }}">
                    </div>
                    <button type="submit" class="btn btn--ghost">Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Guru</th>
                            <th>Deskripsi</th>
                            <th>Lampiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tugases as $tugas)
                            <tr class="data-row">
                                <td>{{ $tugases->firstItem() + $loop->index }}</td>
                                <td>{{ $tugas->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $tugas->judul }}</td>
                                <td>{{ $tugas->guru?->nama ?? 'Guru tidak tersedia' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($tugas->deskripsi, 120) }}</td>
                                <td>
                                    @if ($tugas->file)
                                        <a href="{{ route('tugas.file', $tugas->id) }}">{{ $tugas->file }}</a>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="data-cell-actions">
                                        <a href="{{ route('tugas.edit', $tugas->id) }}" class="btn--icon"
                                            aria-label="Ubah tugas" title="Ubah">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('tugas.delete', $tugas->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn--icon btn--icon-delete"
                                                aria-label="Hapus tugas" title="Hapus">
                                                <svg viewBox="0 0 24 24">
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4h8v2" />
                                                    <path d="M19 6l-1 14H6L5 6" />
                                                    <path d="M10 11v6M14 11v6" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data tugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    @if ($tugases->total() > 0)
                        Menampilkan {{ $tugases->firstItem() }}–{{ $tugases->lastItem() }} dari {{ $tugases->total() }}
                        tugas
                    @else
                        Tidak ada tugas
                    @endif
                </div>
                <div class="pager">{{ $tugases->links() }}</div>
            </div>
        </section>
    </div>
@endsection
