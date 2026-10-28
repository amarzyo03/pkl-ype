@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Siswa · Tugas</span>
            <h1 class="hero-title">Daftar <span class="accent">Tugas</span></h1>
            <p class="hero-sub">Lihat tugas yang diberikan oleh guru.</p>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 32px">#</th>
                            <th>Tanggal</th>
                            <th>Guru</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tugas as $i => $row)
                            <tr class="data-row">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $row->guru?->nama ?? 'Guru tidak tersedia' }}</td>
                                <td>{{ $row->judul }}</td>
                                <td>{{ $row->deskripsi }}</td>
                                <td>
                                    <a href="{{ route('userSiswa.tugas.kerjakan.attempt', $row->id) }}"
                                        class="btn btn--primary">Kerjakan
                                    </a>
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
        </section>
    </div>
@endsection
