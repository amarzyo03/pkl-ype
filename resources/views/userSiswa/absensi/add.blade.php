@extends('app')
@section('content')
    <form action="{{ route('absensi.save') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <section class="hero">
            <div class="hero-text">
                <span class="eyebrow">Siswa · Absensi · Tambah</span>
                <h1 class="hero-title">Tambah <span class="accent">Absensi</span></h1>
                <p class="hero-sub">Catat kehadiran harian Anda.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('userSiswa.absensi') }}" class="btn btn--ghost">Batal</a>
                <button class="btn btn--primary" type="submit">Simpan absensi</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data absensi</span>
                        <h2 class="card-title">{{ $siswa->nama }}</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="tanggal">Tanggal <span class="req">*</span></label>
                        <input class="input" id="tanggal" type="date" name="tanggal"
                            value="{{ old('tanggal', now()->toDateString()) }}" required>
                        @error('tanggal')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="status">Status <span class="req">*</span></label>
                        <select class="select" id="status" name="status" required>
                            @foreach (['hadir', 'sakit', 'izin', 'alpa', 'libur'] as $status)
                                <option value="{{ $status }}" @selected(old('status', 'hadir') === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="foto">Foto</label>
                        <input class="input" id="foto" type="file" name="foto" accept=".jpg,.jpeg,.png,image/*">
                        @error('foto')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field" style="grid-column: 1 / -1">
                        <label class="field-label" for="keterangan">Keterangan</label>
                        <textarea class="input" id="keterangan" name="keterangan" rows="4" maxlength="255">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
