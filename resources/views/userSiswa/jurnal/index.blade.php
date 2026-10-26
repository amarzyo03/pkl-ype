@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Siswa · Jurnal</span>
            <h1 class="hero-title">Jurnal <span class="accent">Kegiatan</span></h1>
            <p class="hero-sub">Catat dan kelola kegiatan harian siswa.</p>
        </div>
        <div class="hero-actions">
            @if ($selectedStudentId)
                <a href="{{ route('userSiswa.jurnal.add', ['id_siswa' => $selectedStudentId]) }}" class="btn btn--primary">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 5v14M5 12h14" />
                    </svg> Tambah jurnal
                </a>
            @endif
        </div>
    </section>

    @if (session('success'))
        <p class="badge success">{{ session('success') }}</p>
    @endif

    <div class="grid">
        <section class="col-12 card">
            <form action="{{ route('userSiswa.jurnal') }}" method="get" class="data-toolbar">
                <div class="data-toolbar-left">
                    <select class="select" name="id_siswa" required>
                        <option value="">Pilih siswa</option>
                        @foreach ($siswa as $item)
                            <option value="{{ $item->id }}" {{ $selectedStudentId === $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    <input class="input" type="search" name="search" placeholder="Cari tanggal, kegiatan, atau ID..."
                        value="{{ request('search', '') }}">
                    <input type="hidden" name="perPage" value="{{ $jurnal->perPage() }}">
                    <button class="btn btn--ghost" type="submit">Tampilkan</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jurnal as $item)
                            <tr class="data-row">
                                <td>{{ $jurnal->firstItem() + $loop->index }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $item->kegiatan }}</td>
                                <td>
                                    <div class="data-cell-actions">
                                        <a href="{{ route('userSiswa.jurnal.edit', ['id' => $item->id, 'id_siswa' => $selectedStudentId]) }}"
                                            class="btn--icon" aria-label="Edit" title="Edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                            </svg>
                                        </a>
                                        <form
                                            action="{{ route('userSiswa.jurnal.delete', ['id' => $item->id, 'id_siswa' => $selectedStudentId]) }}"
                                            method="post" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn--icon btn--icon-delete" aria-label="Hapus"
                                                title="Hapus">
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
                                <td colspan="4" class="text-center text-muted">Belum ada jurnal untuk siswa ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    <span>Menampilkan <strong
                            style="color:var(--t-base)">{{ $jurnal->firstItem() ?? 0 }}–{{ $jurnal->lastItem() ?? 0 }}</strong>
                        dari <strong style="color:var(--t-base)">{{ $jurnal->total() }}</strong></span>
                    <form action="{{ route('userSiswa.jurnal') }}" method="get">
                        <input type="hidden" name="id_siswa" value="{{ $selectedStudentId }}">
                        <input type="hidden" name="search" value="{{ request('search', '') }}">
                        <select class="select" name="perPage" onchange="this.form.submit()">
                            @foreach ([15, 25, 50, 100] as $perPageOption)
                                <option value="{{ $perPageOption }}"
                                    {{ $jurnal->perPage() == $perPageOption ? 'selected' : '' }}>
                                    {{ $perPageOption }} per halaman
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="pager">
                    @if ($jurnal->onFirstPage())
                        <span class="btn--icon disabled" aria-label="Halaman sebelumnya">‹</span>
                    @else
                        <a href="{{ $jurnal->previousPageUrl() }}" class="btn--icon" aria-label="Halaman sebelumnya">‹</a>
                    @endif
                    @foreach ($jurnal->getUrlRange(max(1, $jurnal->currentPage() - 2), min($jurnal->lastPage(), $jurnal->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}"
                            class="btn--icon {{ $page === $jurnal->currentPage() ? 'active' : '' }}"
                            aria-label="Halaman {{ $page }}">{{ $page }}</a>
                    @endforeach
                    @if ($jurnal->hasMorePages())
                        <a href="{{ $jurnal->nextPageUrl() }}" class="btn--icon" aria-label="Halaman berikutnya">›</a>
                    @else
                        <span class="btn--icon disabled" aria-label="Halaman berikutnya">›</span>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
