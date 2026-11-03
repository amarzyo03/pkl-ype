@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Guru · Siswa</span>
            <h1 class="hero-title">Daftar <span class="accent">Siswa</span></h1>
            <p class="hero-sub">Siswa yang terdaftar pada DUDI bimbingan Anda.</p>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="table-responsive" tabindex="0" role="region" aria-label="Tabel siswa bimbingan">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>DUDI</th>
                            <th>Status Pendaftaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswas as $siswa)
                            <tr class="data-row">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->kelas?->nama ?? '-' }}</td>
                                <td>{{ $siswa->pendaftaran?->dudi?->nama ?? '-' }}</td>
                                <td>
                                    @php
                                        $statusClass = match ($siswa->pendaftaran?->status) {
                                            'pending' => 'warning',
                                            'disetujui' => 'success',
                                            'ditolak' => 'danger',
                                            default => 'info',
                                        };
                                    @endphp
                                    <span class="badge dot {{ $statusClass }}">
                                        {{ ucfirst($siswa->pendaftaran?->status ?? 'Tidak tersedia') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Belum ada siswa yang terdaftar pada DUDI bimbingan Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    @if ($siswas->isNotEmpty())
                        Menampilkan {{ $siswas->count() }} siswa
                    @else
                        Tidak ada siswa
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
