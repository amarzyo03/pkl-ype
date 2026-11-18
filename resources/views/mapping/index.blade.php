@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · Mapping Guru</span>
            <h1 class="hero-title">Mapping <span class="accent">Pengajaran</span></h1>
            <p class="hero-sub">Pengaturan guru, mata pelajaran, dan kelas.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('mapping.create') }}" class="btn btn--primary">
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg> Tambah mapping
            </a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <form method="get" action="{{ route('mapping.index') }}" class="data-toolbar">
                <div class="data-toolbar-left">
                    <div class="input-icon" style="flex:1;max-width:320px">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input class="input" type="search" name="search" value="{{ request('search', '') }}"
                            placeholder="Cari guru, mapel, atau kelas...">
                    </div>
                    <select class="select" name="id_guru" aria-label="Filter guru">
                        <option value="">Semua guru</option>
                        @foreach ($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ request('id_guru') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }}{{ $guru->trashed() ? ' (nonaktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <select class="select" name="id_mapel" aria-label="Filter mata pelajaran">
                        <option value="">Semua mata pelajaran</option>
                        @foreach ($mapels as $mapel)
                            <option value="{{ $mapel->id }}" {{ request('id_mapel') == $mapel->id ? 'selected' : '' }}>
                                {{ $mapel->nama }}{{ $mapel->trashed() ? ' (nonaktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <select class="select" name="id_kelas" aria-label="Filter kelas">
                        <option value="">Semua kelas</option>
                        @foreach ($kelas as $kelasOption)
                            <option value="{{ $kelasOption->id }}"
                                {{ request('id_kelas') == $kelasOption->id ? 'selected' : '' }}>
                                {{ $kelasOption->nama }}{{ $kelasOption->trashed() ? ' (nonaktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <select class="select" name="perPage" aria-label="Jumlah data per halaman">
                        @foreach ([15, 25, 50, 100] as $perPageOption)
                            <option value="{{ $perPageOption }}"
                                {{ $mappings->perPage() === $perPageOption ? 'selected' : '' }}>
                                {{ $perPageOption }} per halaman
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn--ghost" type="submit">Filter</button>
                    <a href="{{ route('mapping.index') }}" class="btn btn--ghost">Reset</a>
                </div>
            </form>

            <div class="table-responsive" tabindex="0" role="region" aria-label="Tabel mapping pengajaran">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Guru</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mappings as $mapping)
                            <tr class="data-row">
                                <td>{{ $mappings->firstItem() + $loop->index }}</td>
                                <td>{{ $mapping->guru?->nama ?? 'Guru tidak ditemukan' }}</td>
                                <td>{{ $mapping->mapel?->nama ?? 'Mata pelajaran tidak ditemukan' }}</td>
                                <td>{{ $mapping->kelas?->nama ?? 'Kelas tidak ditemukan' }}</td>
                                <td>
                                    <div class="data-cell-actions">
                                        <a href="{{ route('mapping.edit', $mapping->id) }}" class="btn--icon"
                                            aria-label="Edit" title="Edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('mapping.destroy', $mapping->id) }}" method="post"
                                            style="display:inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus mapping ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn--icon btn--icon-delete"
                                                aria-label="Hapus" title="Hapus">
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
                                <td colspan="5" class="text-center text-muted">Data mapping tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    <span>Menampilkan <strong>{{ $mappings->firstItem() ?? 0 }}–{{ $mappings->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $mappings->total() }}</strong></span>
                </div>
                @if ($mappings->hasPages())
                    @php
                        $currentPage = $mappings->currentPage();
                        $lastPage = $mappings->lastPage();
                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($lastPage, $currentPage + 1);
                    @endphp
                    <nav class="pager" aria-label="Pagination">
                        @if ($mappings->onFirstPage())
                            <button class="pager-btn" type="button" aria-label="Previous" disabled>
                                <svg viewBox="0 0 24 24">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </button>
                        @else
                            <a class="pager-btn" href="{{ $mappings->previousPageUrl() }}" aria-label="Previous">
                                <svg viewBox="0 0 24 24">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                            </a>
                        @endif

                        @if ($startPage > 1)
                            <a class="pager-btn" href="{{ $mappings->url(1) }}">1</a>
                            @if ($startPage > 2)
                                <span class="pager-btn" aria-hidden="true">…</span>
                            @endif
                        @endif

                        @foreach (range($startPage, $endPage) as $page)
                            @if ($page === $currentPage)
                                <span class="pager-btn is-active" aria-current="page">{{ $page }}</span>
                            @else
                                <a class="pager-btn" href="{{ $mappings->url($page) }}">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <span class="pager-btn" aria-hidden="true">…</span>
                            @endif
                            <a class="pager-btn" href="{{ $mappings->url($lastPage) }}">{{ $lastPage }}</a>
                        @endif

                        @if ($mappings->hasMorePages())
                            <a class="pager-btn" href="{{ $mappings->nextPageUrl() }}" aria-label="Next">
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
