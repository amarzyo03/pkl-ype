@extends('app')

@section('content')
    <style>
        .school-dashboard {
            --dashboard-border: var(--border, #e5e7eb);
            --dashboard-muted: var(--t-muted, #64748b);
            --dashboard-surface: var(--bg-card, #fff);
            --dashboard-text: var(--t-base, #0f172a);
            color: var(--dashboard-text);
        }

        .dashboard-heading {
            align-items: flex-end;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-heading h1 {
            font-size: clamp(1.5rem, 3vw, 2rem);
            letter-spacing: -.03em;
            margin: .25rem 0;
        }

        .dashboard-heading p,
        .dashboard-caption {
            color: var(--dashboard-muted);
            margin: 0;
        }

        .dashboard-eyebrow {
            color: var(--dashboard-muted);
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .dashboard-link {
            align-items: center;
            color: var(--primary, #4f46e5);
            display: inline-flex;
            font-size: .875rem;
            font-weight: 650;
            gap: .4rem;
            text-decoration: none;
            white-space: nowrap;
        }

        .dashboard-link:hover {
            text-decoration: underline;
        }

        .dashboard-link svg {
            height: 1rem;
            width: 1rem;
        }

        .dashboard-stats {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            margin-bottom: 1rem;
        }

        .dashboard-card {
            background: var(--dashboard-surface);
            border: 1px solid var(--dashboard-border);
            border-radius: 1rem;
            min-width: 0;
            padding: 1.25rem;
        }

        .dashboard-stat {
            overflow: hidden;
            position: relative;
        }

        .dashboard-stat::after {
            background: var(--stat-color, #4f46e5);
            border-radius: 50%;
            content: "";
            height: 5rem;
            opacity: .08;
            position: absolute;
            right: -1.5rem;
            top: -1.5rem;
            width: 5rem;
        }

        .dashboard-stat-head {
            align-items: center;
            color: var(--dashboard-muted);
            display: flex;
            font-size: .875rem;
            font-weight: 600;
            gap: .65rem;
        }

        .dashboard-stat-icon {
            align-items: center;
            background: color-mix(in srgb, var(--stat-color, #4f46e5) 12%, transparent);
            border-radius: .7rem;
            color: var(--stat-color, #4f46e5);
            display: inline-flex;
            height: 2.4rem;
            justify-content: center;
            width: 2.4rem;
        }

        .dashboard-stat-icon svg {
            height: 1.25rem;
            width: 1.25rem;
        }

        .dashboard-stat-value {
            font-size: clamp(1.8rem, 3vw, 2.25rem);
            font-weight: 750;
            letter-spacing: -.04em;
            line-height: 1.15;
            margin: 1rem 0 .45rem;
        }

        .dashboard-stat-note {
            color: var(--dashboard-muted);
            font-size: .8rem;
        }

        .dashboard-stat-note strong {
            color: var(--dashboard-text);
        }

        .dashboard-panels {
            display: grid;
            gap: 1rem;
            grid-template-columns: minmax(0, 1fr) minmax(0, 2fr);
            margin-bottom: 1rem;
        }

        .dashboard-card-heading {
            align-items: center;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .dashboard-card-heading h2 {
            font-size: 1.05rem;
            letter-spacing: -.015em;
            margin: .25rem 0 0;
        }

        .registration-status-list {
            display: grid;
            gap: 1rem;
        }

        .registration-status {
            display: grid;
            gap: .5rem;
        }

        .registration-status-top {
            align-items: center;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .registration-status-label {
            align-items: center;
            display: inline-flex;
            font-size: .875rem;
            font-weight: 600;
            gap: .55rem;
        }

        .registration-status-dot {
            background: var(--status-color);
            border-radius: 50%;
            height: .55rem;
            width: .55rem;
        }

        .registration-status-count {
            font-size: .875rem;
            font-weight: 700;
        }

        .registration-status-track {
            background: color-mix(in srgb, var(--dashboard-muted) 13%, transparent);
            border-radius: 999px;
            height: .45rem;
            overflow: hidden;
        }

        .registration-status-fill {
            background: var(--status-color);
            border-radius: inherit;
            height: 100%;
            min-width: 0;
        }

        .dashboard-status-summary {
            border-top: 1px solid var(--dashboard-border);
            color: var(--dashboard-muted);
            display: flex;
            font-size: .8rem;
            justify-content: space-between;
            margin-top: 1.2rem;
            padding-top: 1rem;
        }

        .dashboard-status-summary strong {
            color: var(--dashboard-text);
        }

        .dashboard-activity-grid {
            display: grid;
            gap: .75rem;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .dashboard-activity-item {
            background: color-mix(in srgb, var(--dashboard-muted) 6%, transparent);
            border-radius: .8rem;
            padding: .9rem;
        }

        .dashboard-activity-label {
            color: var(--dashboard-muted);
            font-size: .8rem;
        }

        .dashboard-activity-value {
            font-size: 1.4rem;
            font-weight: 720;
            letter-spacing: -.025em;
            margin-top: .3rem;
        }

        .dashboard-table-wrap {
            overflow-x: auto;
        }

        .dashboard-table {
            border-collapse: collapse;
            min-width: 34rem;
            text-align: left;
            width: 100%;
        }

        .dashboard-table th {
            color: var(--dashboard-muted);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            padding: 0 .75rem .75rem;
            text-transform: uppercase;
        }

        .dashboard-table td {
            border-top: 1px solid var(--dashboard-border);
            font-size: .875rem;
            padding: .85rem .75rem;
            vertical-align: middle;
        }

        .dashboard-table th:first-child,
        .dashboard-table td:first-child {
            padding-left: 0;
        }

        .dashboard-table th:last-child,
        .dashboard-table td:last-child {
            padding-right: 0;
        }

        .dashboard-student-name {
            font-weight: 650;
        }

        .dashboard-table-subtext {
            color: var(--dashboard-muted);
            display: block;
            font-size: .78rem;
            margin-top: .2rem;
        }

        .dashboard-badge {
            border-radius: 999px;
            display: inline-flex;
            font-size: .73rem;
            font-weight: 700;
            padding: .3rem .6rem;
            white-space: nowrap;
        }

        .dashboard-badge.is-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .dashboard-badge.is-approved {
            background: #dcfce7;
            color: #166534;
        }

        .dashboard-badge.is-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .dashboard-empty {
            color: var(--dashboard-muted);
            padding: 1.5rem 0;
            text-align: center;
        }

        @media (max-width: 900px) {
            .dashboard-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .dashboard-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .dashboard-panels {
                grid-template-columns: 1fr;
            }

            .dashboard-card {
                padding: 1rem;
            }

            .dashboard-activity-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="school-dashboard">
        <section class="hero">
            <div class="hero-text">
                <span class="eyebrow">{{ now()->format('l, d F Y') }}</span>
                <h1 class="hero-title">Selamat datang, <span class="accent">SMK YPE Kroya</span></h1>
                <p class="hero-sub">Ringkasan data siswa, mitra industri, dan kegiatan praktik kerja.</p>
            </div>
        </section>

        <section class="dashboard-stats" aria-label="Ringkasan data sekolah">
            <article class="dashboard-card dashboard-stat" style="--stat-color:#2563eb">
                <div class="dashboard-stat-head">
                    <span class="dashboard-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6m3-3h-6" />
                        </svg>
                    </span>
                    Jumlah siswa
                </div>
                <div class="dashboard-stat-value">{{ number_format($totalSiswa, 0, ',', '.') }}</div>
                <div class="dashboard-stat-note"><strong>{{ number_format($siswaAktif, 0, ',', '.') }}</strong> siswa aktif
                </div>
            </article>

            <article class="dashboard-card dashboard-stat" style="--stat-color:#7c3aed">
                <div class="dashboard-stat-head">
                    <span class="dashboard-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path
                                d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4M9 9v.01M9 12v.01M9 15v.01M9 18v.01M15 13v.01M15 16v.01M15 19v.01" />
                        </svg>
                    </span>
                    Jumlah guru
                </div>
                <div class="dashboard-stat-value">{{ number_format($jumlahGuru, 0, ',', '.') }}</div>
                <div class="dashboard-stat-note">Guru terdaftar di sekolah</div>
            </article>

            <article class="dashboard-card dashboard-stat" style="--stat-color:#0891b2">
                <div class="dashboard-stat-head">
                    <span class="dashboard-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6M9 9h.01M15 9h.01" />
                        </svg>
                    </span>
                    Jumlah DUDI
                </div>
                <div class="dashboard-stat-value">{{ number_format($jumlahDudi, 0, ',', '.') }}</div>
                <div class="dashboard-stat-note">Mitra dunia usaha dan industri</div>
            </article>

            <article class="dashboard-card dashboard-stat" style="--stat-color:#db2777">
                <div class="dashboard-stat-head">
                    <span class="dashboard-stat-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M8 4h8l4 4v12H4V4h4ZM8 12h8M8 16h8M14 4v5h5" />
                        </svg>
                    </span>
                    Jumlah pendaftaran
                </div>
                <div class="dashboard-stat-value">{{ number_format($totalPendaftaran, 0, ',', '.') }}</div>
                <div class="dashboard-stat-note"><strong>{{ number_format($pendaftaranDisetujui, 0, ',', '.') }}</strong>
                    telah disetujui</div>
            </article>
        </section>

        <div class="dashboard-panels">
            <section class="dashboard-card" aria-labelledby="registration-status-title">
                <div class="dashboard-card-heading">
                    <div>
                        <span class="dashboard-eyebrow">Proses PKL</span>
                        <h2 id="registration-status-title">Status pendaftaran</h2>
                    </div>
                    <a class="dashboard-link" href="{{ route('pendaftaran') }}">
                        Kelola
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14m-7-7 7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="registration-status-list">
                    <div class="registration-status">
                        <div class="registration-status-top">
                            <span class="registration-status-label">
                                <span class="registration-status-dot" style="--status-color:#d97706"></span>
                                Pending
                            </span>
                            <span class="registration-status-count">{{ number_format($pendaftaranPending, 0, ',', '.') }}
                                <span class="dashboard-caption">({{ $persentasePending }}%)</span></span>
                        </div>
                        <div class="registration-status-track" role="progressbar" aria-label="Pendaftaran pending"
                            aria-valuenow="{{ $persentasePending }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="registration-status-fill"
                                style="--status-color:#d97706;width:{{ $persentasePending }}%"></div>
                        </div>
                    </div>

                    <div class="registration-status">
                        <div class="registration-status-top">
                            <span class="registration-status-label">
                                <span class="registration-status-dot" style="--status-color:#16a34a"></span>
                                Disetujui
                            </span>
                            <span class="registration-status-count">{{ number_format($pendaftaranDisetujui, 0, ',', '.') }}
                                <span class="dashboard-caption">({{ $persentaseDisetujui }}%)</span></span>
                        </div>
                        <div class="registration-status-track" role="progressbar" aria-label="Pendaftaran disetujui"
                            aria-valuenow="{{ $persentaseDisetujui }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="registration-status-fill"
                                style="--status-color:#16a34a;width:{{ $persentaseDisetujui }}%"></div>
                        </div>
                    </div>

                    <div class="registration-status">
                        <div class="registration-status-top">
                            <span class="registration-status-label">
                                <span class="registration-status-dot" style="--status-color:#dc2626"></span>
                                Ditolak
                            </span>
                            <span class="registration-status-count">{{ number_format($pendaftaranDitolak, 0, ',', '.') }}
                                <span class="dashboard-caption">({{ $persentaseDitolak }}%)</span></span>
                        </div>
                        <div class="registration-status-track" role="progressbar" aria-label="Pendaftaran ditolak"
                            aria-valuenow="{{ $persentaseDitolak }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="registration-status-fill"
                                style="--status-color:#dc2626;width:{{ $persentaseDitolak }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-status-summary">
                    <span>Total pendaftaran</span>
                    <strong>{{ number_format($totalPendaftaran, 0, ',', '.') }} data</strong>
                </div>
            </section>

            <section class="dashboard-card" aria-labelledby="school-activity-title">
                <div class="dashboard-card-heading">
                    <div>
                        <span class="dashboard-eyebrow">Data pendukung</span>
                        <h2 id="school-activity-title">Aktivitas sekolah</h2>
                    </div>
                </div>

                <div class="dashboard-activity-grid">
                    <div class="dashboard-activity-item">
                        <div class="dashboard-activity-label">Tugas dikerjakan</div>
                        <div class="dashboard-activity-value">
                            {{ number_format($jumlahTugasDikerjakan, 0, ',', '.') }}
                        </div>
                        <div class="dashboard-caption">
                            Belum dikerjakan:
                            <strong>{{ number_format($jumlahTugasBelumDikerjakan, 0, ',', '.') }}</strong>
                            dari {{ number_format($jumlahTugas * $siswaAktif, 0, ',', '.') }} tugas
                        </div>
                    </div>
                    <div class="dashboard-activity-item">
                        <div class="dashboard-activity-label">Jurnal terkumpul bulan ini</div>
                        <div class="dashboard-activity-value">
                            {{ number_format($jumlahJurnalBulanIni, 0, ',', '.') }}
                        </div>
                        <div class="dashboard-caption">
                            Belum mengumpulkan:
                            <strong>{{ number_format($jumlahSiswaBelumMengumpulkanJurnal, 0, ',', '.') }}</strong>
                            siswa
                        </div>
                    </div>
                    <div class="dashboard-activity-item">
                        <div class="dashboard-activity-label">Absensi siswa</div>
                        <div class="dashboard-activity-value">
                            {{ number_format($jumlahAbsensi, 0, ',', '.') }}
                        </div>
                        <div class="dashboard-caption">
                            {{ number_format($jumlahAbsensiHariIni, 0, ',', '.') }} dicatat hari ini
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
