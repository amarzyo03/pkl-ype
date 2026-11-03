@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Guru · Jurnal</span>
            <h1 class="hero-title">Monitoring <span class="accent">Jurnal Siswa</span></h1>
            <p class="hero-sub">Pantau kegiatan siswa dari DUDI bimbingan Anda.</p>
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
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>DUDI</th>
                            <th>Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($jurnal as $item)
                            <tr class="data-row">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $item->siswa?->nama ?? 'Siswa tidak tersedia' }}</td>
                                <td>{{ $item->siswa?->kelas?->nama ?? '-' }}</td>
                                <td>{{ $item->siswa?->pendaftaran?->dudi?->nama ?? '-' }}</td>
                                <td>{{ $item->kegiatan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada jurnal siswa bimbingan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="data-foot">
                <div class="data-foot-info">Menampilkan {{ $jurnal->count() }} jurnal siswa bimbingan</div>
            </div>
        </section>
    </div>
@endsection
