@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Siswa · DUDI</span>
            <h1 class="hero-title">Daftar <span class="accent">Siswa</span></h1>
            <p class="hero-sub">Siswa yang terdaftar pada DUDI yang sama dengan Anda.</p>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarSiswa as $pendaftaran)
                            <tr class="data-row">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst($pendaftaran->siswa?->nama) ?? 'Siswa tidak tersedia' }}</td>
                                <td>{{ strtoupper($pendaftaran->siswa?->kelas?->nama) ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada siswa yang disetujui pada DUDI yang sama.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    @if ($daftarSiswa->isNotEmpty())
                        Menampilkan {{ $daftarSiswa->count() }} siswa
                    @else
                        Tidak ada siswa
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
