@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Siswa · Tugas</span>
            <h1 class="hero-title">Kerjakan <span class="accent">Tugas</span></h1>
            <p class="hero-sub">Isi nama siswa dan unggah jawaban tugas dalam format PDF.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('userSiswa.tugas', ['id_siswa' => $selectedStudentId]) }}" class="btn btn--ghost">Kembali</a>
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

            @if (session('success'))
                <p role="status">{{ session('success') }}</p>
            @endif
            @if (session('error'))
                <p role="alert">{{ session('error') }}</p>
            @endif

            <form action="{{ route('userSiswa.tugas.kerjakan.attempt', $tugas->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="id_siswa">Nama Siswa <span class="req">*</span></label>
                        <select id="id_siswa" class="input" name="id_siswa" required
                            @if ($pengumpulan?->status === 'dikerjakan') disabled @endif>
                            <option value="">Pilih siswa</option>
                            @foreach ($siswa as $item)
                                <option value="{{ $item->id }}" @selected((string) old('id_siswa', $selectedStudentId) === (string) $item->id)>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_siswa')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="nama_guru">Nama Guru</label>
                        <input id="nama_guru" class="input" type="text"
                            value="{{ $tugas->guru?->nama ?? 'Guru tidak tersedia' }}" readonly>
                    </div>

                    <div class="field">
                        <label class="field-label" for="judul">Judul Tugas</label>
                        <input id="judul" class="input" type="text" value="{{ $tugas->judul }}" readonly>
                    </div>

                    <div class="field">
                        <label class="field-label" for="status">Status</label>
                        <input id="status" class="input" type="text"
                            value="{{ $pengumpulan?->status === null ? 'Belum dikerjakan' : ucfirst($pengumpulan->status) }}"
                            readonly>
                    </div>

                    <div class="field" style="grid-column: 1 / -1">
                        <label class="field-label" for="deskripsi">Deskripsi Tugas</label>
                        <textarea id="deskripsi" class="input" rows="5" readonly>{{ $tugas->deskripsi }}</textarea>
                    </div>

                    <div class="field" style="grid-column: 1 / -1">
                        <label class="field-label" for="file">File Tugas (PDF) <span class="req">*</span></label>
                        <input id="file" class="input" type="file" name="file" accept=".pdf,application/pdf"
                            @if ($pengumpulan?->status === 'dikerjakan') disabled
                            @else
                                required @endif>
                        <small class="text-muted">
                            {{ $pengumpulan?->status === 'dikerjakan' ? 'Unggahan terkunci. Batalkan pengerjaan untuk mengunggah file kembali.' : 'File harus PDF, maksimal 2 MB.' }}
                        </small>
                        @if ($pengumpulan?->file)
                            <small>
                                File terkumpul:
                                <a href="{{ asset('assets/static/pengumpulan-tugas/' . $pengumpulan->file) }}">
                                    {{ $pengumpulan->file }}
                                </a>
                            </small>
                        @endif
                        @error('file')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                @if ($pengumpulan?->status === 'dikerjakan')
                    <button class="btn btn--primary" type="submit" disabled>Kirim Tugas</button>
                @else
                    <button class="btn btn--primary" type="submit">Kirim Tugas</button>
                @endif
            </form>
            @if ($pengumpulan?->status === 'dikerjakan')
                <form action="{{ route('userSiswa.tugas.kerjakan.cancel', $tugas->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_siswa" value="{{ $selectedStudentId }}">
                    <button class="btn btn--ghost" type="submit">Batalkan pengerjaan tugas</button>
                </form>
            @endif
        </section>
    </div>
@endsection
