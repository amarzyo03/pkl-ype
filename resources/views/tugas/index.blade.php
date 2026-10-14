@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Manajemen · Tugas</span>
            <h1 class="hero-title">Data <span class="accent">Tugas</span></h1>
            <p class="hero-sub">Kelola tugas dan lampiran.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('tugas.add') }}" class="btn btn--primary">
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg> Tambah tugas
            </a>
        </div>
    </section>

    @if (session('success'))
        <p class="badge success">{{ session('success') }}</p>
    @endif

    <div class="grid">
        <section class="col-12 card">
            <form action="{{ route('tugas') }}" method="get" class="data-toolbar">
                <div class="data-toolbar-left">
                    <div class="input-icon" style="flex:1;max-width:420px">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input class="input" type="search" name="search"
                            placeholder="Cari pengirim, judul, deskripsi, atau ID..." value="{{ request('search', '') }}">
                    </div>
                    <button class="btn btn--ghost" type="submit">Cari</button>
                </div>
                <input type="hidden" name="perPage" value="{{ $tugases->perPage() }}">
            </form>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Pengirim</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Lampiran</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tugases as $row)
                            <tr class="data-row">
                                <td>{{ $tugases->firstItem() + $loop->index }}</td>
                                <td>{{ $row->pengirim }}</td>
                                <td>{{ $row->judul }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($row->deskripsi, 100) }}</td>
                                <td><a href="{{ route('tugas.file', $row->id) }}">Unduh lampiran</a></td>
                                <td>
                                    <div class="data-cell-actions">
                                        <a href="{{ route('tugas.edit', $row->id) }}" class="btn--icon" aria-label="Edit"
                                            title="Edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('tugas.delete', $row->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn--icon btn--icon-delete" aria-label="Delete"
                                                title="Delete">
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
                                <td colspan="6" class="text-center text-muted">Belum ada data tugas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    <span>Menampilkan <strong
                            style="color:var(--t-base)">{{ $tugases->firstItem() ?? 0 }}–{{ $tugases->lastItem() ?? 0 }}</strong>
                        dari <strong style="color:var(--t-base)">{{ $tugases->total() }}</strong></span>
                    <form action="{{ route('tugas') }}" method="get">
                        <input type="hidden" name="search" value="{{ request('search', '') }}">
                        <select class="select" name="perPage" onchange="this.form.submit()">
                            @foreach ([15, 25, 50, 100] as $perPageOption)
                                <option value="{{ $perPageOption }}"
                                    {{ $tugases->perPage() == $perPageOption ? 'selected' : '' }}>{{ $perPageOption }} per
                                    halaman</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="pager">
                    @if ($tugases->onFirstPage())
                        <span class="btn--icon disabled" aria-label="Halaman sebelumnya">‹</span>
                    @else
                        <a href="{{ $tugases->previousPageUrl() }}" class="btn--icon" aria-label="Halaman sebelumnya">‹</a>
                    @endif
                    @foreach ($tugases->getUrlRange(max(1, $tugases->currentPage() - 2), min($tugases->lastPage(), $tugases->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}"
                            class="btn--icon {{ $page === $tugases->currentPage() ? 'active' : '' }}"
                            aria-label="Halaman {{ $page }}">{{ $page }}</a>
                    @endforeach
                    @if ($tugases->hasMorePages())
                        <a href="{{ $tugases->nextPageUrl() }}" class="btn--icon" aria-label="Halaman berikutnya">›</a>
                    @else
                        <span class="btn--icon disabled" aria-label="Halaman berikutnya">›</span>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
