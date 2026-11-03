@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">{{ now()->format('l, d F Y') }}</span>
            <h1 class="hero-title">Selamat datang, <span class="accent">{{ $guru->nama }}</span></h1>
            <p class="hero-sub">Ringkasan DUDI, siswa bimbingan, absensi, dan tugas Anda.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('userGuru.daftarDudi') }}" class="btn btn--ghost">DUDI</a>
            <a href="{{ route('userGuru.daftarSiswa') }}" class="btn btn--ghost">Siswa</a>
            <a href="{{ route('userGuru.absensi') }}" class="btn btn--ghost">Absensi</a>
            <a href="{{ route('tugas') }}" class="btn btn--ghost">Tugas</a>
        </div>
    </section>

    <section class="kpi-grid" aria-label="Ringkasan aktivitas guru">
        <article class="kpi-card c-success">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon success"><svg viewBox="0 0 24 24">
                            <path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" />
                            <path d="M9 9v.01M9 13v.01M9 17v.01M16 13v.01M16 17v.01" />
                        </svg></div>
                    <div class="kpi-label">DUDI bimbingan</div>
                </div>
            </div>
            <div class="kpi-value">{{ $totalDudi }}</div>
            <div class="kpi-compare">{{ $dudi->pluck('nama')->join(', ') ?: 'Belum ada DUDI bimbingan' }}</div>
        </article>
        <article class="kpi-card c-danger">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon danger"><svg viewBox="0 0 24 24">
                            <circle cx="9" cy="8" r="4" />
                            <path d="M2 21c0-4 3-7 7-7s7 3 7 7M16 4a4 4 0 0 1 0 8M18 14c2 1 4 3 4 7" />
                        </svg></div>
                    <div class="kpi-label">Siswa bimbingan</div>
                </div>
            </div>
            <div class="kpi-value">{{ $totalSiswa }}</div>
            <div class="kpi-compare">Siswa dengan pendaftaran disetujui</div>
        </article>
        <article class="kpi-card c-purple">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon purple"><svg viewBox="0 0 24 24">
                            <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                        </svg></div>
                    <div class="kpi-label">Total tugas</div>
                </div>
            </div>
            <div class="kpi-value">{{ $totalTugas }}</div>
            <div class="kpi-compare">{{ $totalPengumpulan }} pengumpulan dari siswa bimbingan</div>
        </article>
        <article class="kpi-card c-primary">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon primary"><svg viewBox="0 0 24 24">
                            <path d="M20 6 9 17l-5-5" />
                        </svg></div>
                    <div class="kpi-label">Total absensi</div>
                </div>
            </div>
            <div class="kpi-value">{{ $totalAbsensi }}</div>
            <div class="kpi-compare">Catatan absensi siswa bimbingan</div>
        </article>
    </section>

    <section class="grid">
        <article class="col-6 card">
            <div class="card-head">
                <div class="card-title-wrap">
                    <span class="eyebrow">Aktivitas terbaru</span>
                    <h2 class="card-title">Absensi terakhir</h2>
                </div>
                <a class="btn btn--ghost" href="{{ route('userGuru.absensi') }}">Lihat semua</a>
            </div>
            @if ($absensiTerbaru)
                <p>{{ $absensiTerbaru->tanggal->format('d/m/Y') }} · {{ $absensiTerbaru->siswa?->nama ?? 'Siswa tidak tersedia' }}
                    · {{ ucfirst($absensiTerbaru->status) }}</p>
                @if ($absensiTerbaru->siswa?->kelas)
                    <p class="text-muted">{{ $absensiTerbaru->siswa->kelas->nama }}</p>
                @endif
            @else
                <p class="text-muted">Belum ada absensi dari siswa bimbingan.</p>
            @endif
        </article>

        <article class="col-6 card">
            <div class="card-head">
                <div class="card-title-wrap">
                    <span class="eyebrow">Tugas Anda</span>
                    <h2 class="card-title">Tugas terbaru</h2>
                </div>
                <a class="btn btn--ghost" href="{{ route('tugas') }}">Lihat semua</a>
            </div>
            @if ($tugasTerbaru)
                <p>{{ $tugasTerbaru->tanggal->format('d/m/Y') }} · {{ $tugasTerbaru->judul }}</p>
                <a href="{{ route('tugas.status', $tugasTerbaru->id) }}">Lihat status pengumpulan</a>
            @else
                <p class="text-muted">Belum ada tugas yang dibuat.</p>
            @endif
        </article>
    </section>
@endsection
