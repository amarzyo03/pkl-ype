@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">{{ now()->format('l, d F Y') }}</span>
            <h1 class="hero-title">Selamat datang, <span class="accent">{{ $siswa->nama }}</span></h1>
            <p class="hero-sub">
                {{ $siswa->kelas?->nama ?? 'Kelas belum tersedia' }}
                @if ($pendaftaran?->status === 'disetujui' && $pendaftaran->dudi)
                    · PKL di {{ $pendaftaran->dudi->nama }}
                @endif
            </p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('userSiswa.pendaftaran.status') }}" class="btn btn--ghost">PKL</a>
            <a href="{{ route('userSiswa.daftarSiswa') }}" class="btn btn--ghost">Siswa</a>
            <a href="{{ route('userSiswa.absensi') }}" class="btn btn--ghost">Absensi</a>
            <a href="{{ route('userSiswa.jurnal') }}" class="btn btn--ghost">Jurnal</a>
            <a href="{{ route('userSiswa.tugas') }}" class="btn btn--ghost">Tugas</a>
        </div>
    </section>

    <section class="kpi-grid" aria-label="Ringkasan aktivitas siswa">
        <article class="kpi-card c-success">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon success"><svg viewBox="0 0 24 24">
                            <path d="M20 6 9 17l-5-5" />
                        </svg></div>
                    <div class="kpi-label">Total absensi</div>
                </div><span class="kpi-pill up"><svg viewBox="0 0 24 24">
                        <path d="M5 12h14" />
                    </svg> Catatan</span>
            </div>
            <div class="kpi-value">{{ $totalAbsensi }}</div>
            <div class="kpi-compare">Jumlah catatan absensi Anda</div>
        </article>
        <article class="kpi-card c-danger">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon danger"><svg viewBox="0 0 24 24">
                            <path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                        </svg></div>
                    <div class="kpi-label">Total tugas</div>
                </div><span class="kpi-pill down"><svg viewBox="0 0 24 24">
                        <path d="M5 12h14" />
                    </svg> Tersedia</span>
            </div>
            <div class="kpi-value">{{ $totalTugas }}</div>
            <div class="kpi-compare">{{ $tugasSelesai }} tugas telah Anda kumpulkan</div>
        </article>
        <article class="kpi-card c-purple">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon purple"><svg viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="17" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg></div>
                    <div class="kpi-label">Total jurnal</div>
                </div><span class="kpi-pill flat"><svg viewBox="0 0 24 24">
                        <path d="M5 12h14" />
                    </svg> Kegiatan</span>
            </div>
            <div class="kpi-value">{{ $totalJurnal }}</div>
            <div class="kpi-compare">Catatan kegiatan yang sudah dibuat</div>
        </article>
        <article class="kpi-card c-primary">
            <div class="kpi-top">
                <div class="kpi-identity">
                    <div class="kpi-icon primary"><svg viewBox="0 0 24 24">
                            <path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4" />
                            <path d="M9 9v.01M9 13v.01M9 17v.01M16 13v.01M16 17v.01" />
                        </svg></div>
                    <div class="kpi-label">Status PKL</div>
                </div><span class="kpi-pill info"><svg viewBox="0 0 24 24">
                        <path d="M5 12h14" />
                    </svg> Pendaftaran</span>
            </div>
            <div class="kpi-value" style="font-size: 1.5rem">
                {{ $pendaftaran ? ucfirst($pendaftaran->status) : 'Belum mendaftar' }}
            </div>
            <div class="kpi-compare">
                @if ($pendaftaran?->status === 'disetujui' && $pendaftaran->dudi)
                    {{ $pendaftaran->dudi->nama }}
                @elseif ($pendaftaran?->status === 'pending')
                    Menunggu persetujuan
                @else
                    <a href="{{ route('userSiswa.pendaftaran') }}">Daftar tempat PKL</a>
                @endif
            </div>
        </article>
    </section>

    <section class="grid">
        <article class="col-6 card">
            <div class="card-head">
                <div class="card-title-wrap">
                    <span class="eyebrow">Aktivitas terbaru</span>
                    <h2 class="card-title">Absensi terakhir</h2>
                </div>
                <a class="btn btn--ghost" href="{{ route('userSiswa.absensi') }}">Lihat semua</a>
            </div>
            @if ($absensiTerbaru)
                <p>{{ $absensiTerbaru->tanggal->format('d/m/Y') }} · {{ ucfirst($absensiTerbaru->status) }}</p>
                @if ($absensiTerbaru->keterangan)
                    <p class="text-muted">{{ $absensiTerbaru->keterangan }}</p>
                @endif
            @else
                <p class="text-muted">Belum ada catatan absensi.</p>
            @endif
        </article>

        <article class="col-6 card">
            <div class="card-head">
                <div class="card-title-wrap">
                    <span class="eyebrow">Catatan kegiatan</span>
                    <h2 class="card-title">Jurnal terakhir</h2>
                </div>
                <a class="btn btn--ghost" href="{{ route('userSiswa.jurnal') }}">Lihat semua</a>
            </div>
            @if ($jurnalTerbaru)
                <p>{{ \Illuminate\Support\Carbon::parse($jurnalTerbaru->tanggal)->format('d/m/Y') }}</p>
                <p class="text-muted">{{ $jurnalTerbaru->kegiatan }}</p>
            @else
                <p class="text-muted">Belum ada catatan jurnal.</p>
            @endif
        </article>
    </section>
@endsection
