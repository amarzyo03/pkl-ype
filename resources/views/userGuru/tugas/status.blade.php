@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Workspace · Tugas · Status</span>
            <h1 class="hero-title">Status <span class="accent">Pengerjaan</span></h1>
            <p class="hero-sub">Daftar siswa untuk tugas: {{ $tugas->judul }}</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('tugas') }}" class="btn btn--ghost">Kembali ke Tugas</a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="card-head">
                <div class="card-title-wrap">
                    <span class="eyebrow">Rekap pengerjaan</span>
                    <h2 class="card-title">Status Siswa ({{ $siswas->count() }})</h2>
                </div>
            </div>
            <div class="data-foot-info" style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:16px">
                <span class="badge dot success">Sudah mengerjakan: {{ $jumlahSelesai }} siswa</span>
                <span class="badge dot warning">Belum mengerjakan: {{ $jumlahBelum }} siswa</span>
            </div>
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Status</th>
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
                                <td>
                                    @if ($siswaSelesaiIds->contains($siswa->id))
                                        <span class="badge dot success">Sudah mengerjakan</span>
                                    @else
                                        <span class="badge dot warning">Belum mengerjakan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada siswa terdaftar pada DUDI guru ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
