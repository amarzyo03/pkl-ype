@extends('app')
@section('content')
    <form action="{{ route('userSiswa.jurnal.save') }}" method="post">
        @csrf

        <section class="hero">
            <div class="hero-text">
                <span class="eyebrow">Siswa · Jurnal · Tambah</span>
                <h1 class="hero-title">Tambah <span class="accent">Jurnal</span></h1>
                <p class="hero-sub">Catat kegiatan harian siswa.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('userSiswa.jurnal', ['id_siswa' => $selectedStudentId]) }}"
                    class="btn btn--ghost">Batal</a>
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
                        <label class="field-label" for="id_siswa">Siswa <span class="req">*</span></label>
                        <select class="select" id="id_siswa" name="id_siswa" required>
                            <option value="">Pilih siswa</option>
                            @foreach ($siswa as $item)
                                <option value="{{ $item->id }}"
                                    {{ (string) old('id_siswa', $selectedStudentId) === (string) $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_siswa')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="tanggal">Tanggal <span class="req">*</span></label>
                        <input class="input" id="tanggal" type="date" name="tanggal"
                            value="{{ old('tanggal', now()->toDateString()) }}" required>
                        @error('tanggal')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field" style="grid-column:1 / -1">
                        <label class="field-label" for="kegiatan">Kegiatan <span class="req">*</span></label>
                        <textarea class="input" id="kegiatan" name="kegiatan" rows="5" maxlength="255" required>{{ old('kegiatan') }}</textarea>
                        @error('kegiatan')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
