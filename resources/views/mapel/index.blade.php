@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · Mata Pelajaran</span>
            <h1 class="hero-title">Data <span class="accent">Mata Pelajaran</span></h1>
            <p class="hero-sub">Manajemen data mata pelajaran</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('mapel.add') }}" class="btn btn--primary">
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg> Tambah mata pelajaran
            </a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <form method="get" action="{{ route('mapel') }}" class="data-toolbar">
                <div class="data-toolbar-left">
                    <div class="input-icon" style="flex:1;max-width:420px">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input class="input" type="search" name="search"
                            placeholder="Cari kode, nama, jenis, atau ID..." value="{{ request('search', '') }}">
                    </div>
                    <select class="select" name="perPage" aria-label="Jumlah data per halaman">
                        @foreach ([15, 25, 50, 100] as $perPageOption)
                            <option value="{{ $perPageOption }}"
                                {{ $mapels->perPage() === $perPageOption ? 'selected' : '' }}>
                                {{ $perPageOption }} per halaman
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn--ghost" type="submit">Cari</button>
                </div>
            </form>

            <div class="table-responsive" tabindex="0" role="region" aria-label="Tabel data mata pelajaran">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mapels as $mapel)
                            <tr class="data-row">
                                <td>{{ $mapels->firstItem() + $loop->index }}</td>
                                <td>{{ strtoupper($mapel->kode) }}</td>
                                <td>{{ $mapel->nama }}</td>
                                <td>{{ ucfirst($mapel->jenis) }}</td>
                                <td>
                                    <div class="data-cell-actions">
                                        <a href="{{ route('mapel.edit', $mapel->id) }}" class="btn--icon"
                                            aria-label="Edit" title="Edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('mapel.delete', $mapel->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn--icon btn--icon-delete"
                                                aria-label="Delete" title="Delete">
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
                                <td colspan="5" class="text-center text-muted">Data mata pelajaran tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    <span>Menampilkan <strong>{{ $mapels->firstItem() ?? 0 }}–{{ $mapels->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $mapels->total() }}</strong></span>
                </div>
                @if ($mapels->hasPages())
                    @php
                        $currentPage = $mapels->currentPage();
                        $lastPage = $mapels->lastPage();
                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($lastPage, $currentPage + 1);
                    @endphp
                    <nav class="pager" aria-label="Pagination">
                        @if ($mapels->onFirstPage())
                            <button class="pager-btn" type="button" aria-label="Previous" disabled>
                                <svg viewBox="0 0 24 24">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </button>
                        @else
                            <a class="pager-btn" href="{{ $mapels->previousPageUrl() }}" aria-label="Previous">
                                <svg viewBox="0 0 24 24">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </a>
                        @endif

                        @if ($startPage > 1)
                            <a class="pager-btn" href="{{ $mapels->url(1) }}">1</a>
                            @if ($startPage > 2)
                                <span class="pager-btn" aria-hidden="true">…</span>
                            @endif
                        @endif

                        @foreach (range($startPage, $endPage) as $page)
                            @if ($page === $currentPage)
                                <span class="pager-btn is-active" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="pager-btn" href="{{ $mapels->url($page) }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <span class="pager-btn" aria-hidden="true">…</span>
                            @endif
                            <a class="pager-btn" href="{{ $mapels->url($lastPage) }}">{{ $lastPage }}</a>
                        @endif

                        @if ($mapels->hasMorePages())
                            <a class="pager-btn" href="{{ $mapels->nextPageUrl() }}" aria-label="Next">
                                <svg viewBox="0 0 24 24">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </a>
                        @else
                            <button class="pager-btn" type="button" aria-label="Next" disabled>
                                <svg viewBox="0 0 24 24">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </button>
                        @endif
                    </nav>
                @endif
            </div>
        </section>
    </div>
@endsection
