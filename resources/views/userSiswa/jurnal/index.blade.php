@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Siswa · Jurnal</span>
            <h1 class="hero-title">Jurnal <span class="accent">Kegiatan</span></h1>
            <p class="hero-sub">Catat dan kelola kegiatan harian Anda.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('userSiswa.jurnal.add') }}" class="btn btn--primary">Tambah jurnal</a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="table-responsive" tabindex="0" role="region" aria-label="Tabel jurnal siswa">
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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $item->kegiatan }}</td>
                                <td>
                                    <div class="data-cell-actions">
                                        <a href="{{ route('userSiswa.jurnal.edit', $item->id) }}"
                                            class="btn--icon" aria-label="Edit" title="Edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                            </svg>
                                        </a>
                                        <form
                                            action="{{ route('userSiswa.jurnal.delete', $item->id) }}"
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
                                <td colspan="4" class="text-center text-muted">Belum ada jurnal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
