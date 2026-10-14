@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Manajemen · Pendaftaran</span>
            <h1 class="hero-title">Data <span class="accent">Pendaftaran</span></h1>
            <p class="hero-sub">Kelola pendaftaran ke mitra DUDI.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('pendaftaran.add') }}" class="btn btn--primary">
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg> Tambah pendaftaran
            </a>
        </div>
    </section>

    @if (session('success'))
        <p class="badge success">{{ session('success') }}</p>
    @endif

    <div class="grid">
        <section class="col-12 card">
            <form action="{{ route('pendaftaran') }}" method="get" class="data-toolbar">
                <div class="data-toolbar-left">
                    <div class="input-icon" style="flex:1;max-width:420px">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input class="input" type="search" name="search" placeholder="Cari nama, DUDI, atau ID..."
                            value="{{ request('search', '') }}">
                    </div>
                    <button class="btn btn--ghost" type="submit">Cari</button>
                </div>
                <input type="hidden" name="perPage" value="{{ $pendaftarans->perPage() }}">
            </form>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Nama</th>
                            <th>DUDI</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftarans as $row)
                            <tr class="data-row">
                                <td>{{ $pendaftarans->firstItem() + $loop->index }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->dudi }}</td>
                                <td>
                                    <div class="data-cell-actions">
                                        <a href="{{ route('pendaftaran.edit', $row->id) }}" class="btn--icon"
                                            aria-label="Edit" title="Edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('pendaftaran.delete', $row->id) }}" method="post"
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
                                <td colspan="4" class="text-center text-muted">Belum ada data pendaftaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    <span>Menampilkan <strong
                            style="color:var(--t-base)">{{ $pendaftarans->firstItem() ?? 0 }}–{{ $pendaftarans->lastItem() ?? 0 }}</strong>
                        dari <strong style="color:var(--t-base)">{{ $pendaftarans->total() }}</strong></span>
                    <form action="{{ route('pendaftaran') }}" method="get">
                        <input type="hidden" name="search" value="{{ request('search', '') }}">
                        <select class="select" name="perPage" onchange="this.form.submit()">
                            @foreach ([15, 25, 50, 100] as $perPageOption)
                                <option value="{{ $perPageOption }}"
                                    {{ $pendaftarans->perPage() == $perPageOption ? 'selected' : '' }}>
                                    {{ $perPageOption }} per halaman</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="pager">
                    @if ($pendaftarans->onFirstPage())
                        <span class="btn--icon disabled" aria-label="Halaman sebelumnya">‹</span>
                    @else
                        <a href="{{ $pendaftarans->previousPageUrl() }}" class="btn--icon"
                            aria-label="Halaman sebelumnya">‹</a>
                    @endif
                    @foreach ($pendaftarans->getUrlRange(max(1, $pendaftarans->currentPage() - 2), min($pendaftarans->lastPage(), $pendaftarans->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}"
                            class="btn--icon {{ $page === $pendaftarans->currentPage() ? 'active' : '' }}"
                            aria-label="Halaman {{ $page }}">{{ $page }}</a>
                    @endforeach
                    @if ($pendaftarans->hasMorePages())
                        <a href="{{ $pendaftarans->nextPageUrl() }}" class="btn--icon"
                            aria-label="Halaman berikutnya">›</a>
                    @else
                        <span class="btn--icon disabled" aria-label="Halaman berikutnya">›</span>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
