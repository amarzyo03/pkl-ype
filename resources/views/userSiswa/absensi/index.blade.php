@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Siswa · Absensi</span>
            <h1 class="hero-title">Daftar <span class="accent">Absensi</span></h1>
            <p class="hero-sub">
                {{ ucwords($siswa_info->nama) . ' · ' . strtoupper($siswa_info->kelas->nama) . ' · ' . ucwords($dudi->dudi->nama) }}
            </p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('userSiswa.absensi.add') }}" class="btn btn--primary">ABSEN</a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            @if (session('success'))
                <p role="status">{{ session('success') }}</p>
            @endif
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 32px">#</th>
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($absensi as $i => $row)
                            <tr class="data-row">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->tanggal->format('d/m/Y') }}</td>
                                <td>
                                    @if ($row->foto)
                                        <a href="{{ asset('assets/static/absensi/' . $row->foto) }}" target="_blank"
                                            rel="noopener">
                                            Lihat foto
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $row->keterangan }}</td>
                                <td>{{ $row->status }}</td>
                                <td>
                                    <a class="btn btn--ghost" href="{{ route('absensi.edit', $row->id) }}">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data absensi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
