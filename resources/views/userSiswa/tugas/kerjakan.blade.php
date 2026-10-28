@extends('app')
@section('content')
    <style>
        .task-attachment-link {
            align-items: center;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--t-base);
            display: flex;
            gap: 14px;
            max-width: 420px;
            padding: 16px;
            text-decoration: none;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .task-attachment-link:hover {
            background-color: var(--bg-hover);
            border-color: var(--primary-light);
        }

        .task-attachment-file-icon {
            align-items: center;
            background: var(--primary-soft);
            border-radius: 8px;
            color: var(--primary);
            display: flex;
            flex: 0 0 42px;
            height: 48px;
            justify-content: center;
        }

        .task-attachment-info {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .task-attachment-name {
            font-weight: 600;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .task-attachment-type {
            color: var(--t-muted);
            font-size: 0.875rem;
        }

        .task-attachment-download {
            color: var(--t-muted);
            flex: 0 0 22px;
        }

        .task-actions {
            display: flex;
            gap: 12px;
            margin-top: 0.5rem;
        }

        .task-actions form {
            margin: 0;
        }

        @media (max-width: 720px) {
            .task-actions {
                flex-direction: column;
            }

            .task-actions .btn {
                width: 100%;
            }
        }
    </style>

    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Siswa · Tugas</span>
            <h1 class="hero-title">Kerjakan <span class="accent">Tugas</span></h1>
            <p class="hero-sub">Isi nama siswa dan unggah jawaban tugas dalam format PDF.</p>
        </div>
        <div class="hero-actions">
            <a href="#" class="btn btn--ghost">Kembali</a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="card-head">
                <div class="card-title-wrap">
                    <span class="eyebrow">Informasi pengumpulan</span>
                    <h2 class="card-title">{{ $tugas->judul }}</h2>
                </div>
            </div>

            <form id="taskSubmissionForm" action="{{ route('userSiswa.tugas.kerjakan.attempt', $tugas->id) }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="nama">Siswa<span class="req">*</span></label>
                        <input class="input" type="hidden" id="nama" name="nama" value="{{ $siswa->id }}">
                        <input class="input" type="text" value="{{ ucwords($siswa->nama) }}" readonly>
                    </div>

                    <div class="field">
                        <label class="field-label" for="nama_guru">Guru</label>
                        <input class="input" type="hidden" id="nama" name="id_guru" value="{{ $siswa->id }}">
                        <input class="input" type="text" value="{{ ucwords($tugas->guru->nama) }}" readonly>
                    </div>

                    <div class="field">
                        <label class="field-label" for="judul">Judul Tugas</label>
                        <input id="judul" class="input" type="text" value="{{ ucwords($tugas->judul) }}" readonly>
                    </div>

                    <div class="field">
                        <label class="field-label" for="status">Status Tugas</label>
                        <input id="status" class="input" type="text"
                            value="{{ $tugas_status?->status === 'dikerjakan' ? 'Sudah dikerjakan' : 'Belum dikerjakan' }}"
                            readonly>
                    </div>

                    <div class="field">
                        <label class="field-label" for="deskripsi">Deskripsi Tugas</label>
                        <textarea id="deskripsi" class="input" rows="3" readonly>{{ ucfirst($tugas->deskripsi) }}</textarea>
                    </div>
                    <div class="field">
                        <span class="field-label">Download Tugas</span>
                        <a class="task-attachment-link" href="{{ asset('assets/static/tugas/' . $tugas->file) }}"
                            download="{{ $tugas->file }}" aria-label="Download lampiran tugas">
                            <span class="task-attachment-file-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 2.75h8l4 4v14.5H6a2 2 0 0 1-2-2V4.75a2 2 0 0 1 2-2Z" stroke="currentColor"
                                        stroke-width="1.7" stroke-linejoin="round" />
                                    <path d="M14 2.75v4h4M7.5 15h9M7.5 18h6" stroke="currentColor" stroke-width="1.7"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="task-attachment-info">
                                <span class="task-attachment-name">{{ ucwords($tugas->file) }}</span>
                                <span class="task-attachment-type">File lampiran</span>
                            </span>
                            <svg class="task-attachment-download" viewBox="0 0 24 24" width="22" height="22"
                                fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 3.75v11m0 0 4-4m-4 4-4-4M5 16.75v3.5h14v-3.5" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    <div class="field">
                        <label class="field-label" for="file">
                            Upload File Pengerjaan Tugas (PDF)
                            <span class="req">*</span>
                        </label>
                        <input id="file" class="input" type="file" name="file"
                            accept=".pdf,application/pdf" style="padding: 1rem 1rem 1rem 1rem"
                            {{ $tugas_status?->status === 'dikerjakan' ? 'disabled' : '' }}>
                        <small
                            class="text-muted">{{ $tugas_status?->status === 'dikerjakan' ? 'Terima kasih telah mengerjakan tugas' : 'File yang diupload max 1 mb' }}</small>
                        @error('file')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="field">
                        <span class="field-label">File yang dikumpulkan</span>
                        @if ($tugas_status?->file)
                            <a class="task-attachment-link"
                                href="{{ asset('assets/static/tugas-pengumpulan/' . $tugas_status->file) }}"
                                download="{{ $tugas_status->file }}" aria-label="Download lampiran tugas">
                                <span class="task-attachment-file-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 2.75h8l4 4v14.5H6a2 2 0 0 1-2-2V4.75a2 2 0 0 1 2-2Z"
                                            stroke="currentColor" stroke-width="1.7" stroke-linejoin="round" />
                                        <path d="M14 2.75v4h4M7.5 15h9M7.5 18h6" stroke="currentColor" stroke-width="1.7"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span class="task-attachment-info">
                                    <span class="task-attachment-name">{{ $tugas_status->file }}</span>
                                    <span class="task-attachment-type">File lampiran</span>
                                </span>
                                <svg class="task-attachment-download" viewBox="0 0 24 24" width="22" height="22"
                                    fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M12 3.75v11m0 0 4-4m-4 4-4-4M5 16.75v3.5h14v-3.5" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        @else
                            <span class="field-label">.:: <i>Belum ada tugas yang dikirim</i> ::.</span>
                        @endif
                    </div>
                </div>
            </form>
            <div class="task-actions">
                @if ($tugas_status?->status !== 'dikerjakan')
                    <button class="btn btn--primary" type="submit" form="taskSubmissionForm">Kirim Tugas</button>
                @endif
                @if ($tugas_status?->status === 'dikerjakan')
                    <form action="{{ route('userSiswa.tugas.kerjakan.cancel', $tugas->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
                        <button class="btn btn--danger" type="submit">Batalkan Pengerjaan Tugas</button>
                    </form>
                @endif
            </div>
        </section>
    </div>
@endsection
