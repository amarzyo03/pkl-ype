@extends('app')
@section('content')
    <form action="{{ route('userSiswa.jurnal.save') }}" method="post">
        @csrf

        <section class="hero">
            <div class="hero-text">
                <span class="eyebrow">Siswa · Jurnal · Tambah</span>
                <h1 class="hero-title">Tambah <span class="accent">Jurnal</span></h1>
                <p class="hero-sub">Catat kegiatan harian Anda.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('userSiswa.jurnal') }}" class="btn btn--ghost">Batal</a>
                <button class="btn btn--primary" type="submit">Simpan jurnal</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data jurnal</span>
                        <h2 class="card-title">Jurnal baru</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="nama">Nama siswa</label>
                        <input class="input" id="nama" type="text" value="{{ $siswa->nama }}" readonly>
                    </div>
                    <div class="field">
                        <label class="field-label" for="tanggal">Tanggal <span class="req">*</span></label>
                        <input class="input" id="tanggal" type="date" name="tanggal"
                            value="{{ old('tanggal', now()->toDateString()) }}" max="{{ now()->toDateString() }}" required>
                        @error('tanggal')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field" style="grid-column:1 / -1">
                        <label class="field-label" for="kegiatan">Kegiatan <span class="req">*</span></label>
                        <textarea class="input" id="kegiatan" name="kegiatan" rows="5" maxlength="255" required>{{ old('kegiatan') }}</textarea>
                        @error('kegiatan')
                            <small role="alert">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
