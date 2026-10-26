@extends('app')
@section('content')
    <form action="{{ route('userSiswa.jurnal.update', $jurnal->id) }}" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">

        <section class="hero">
            <div class="hero-text">
                <span class="eyebrow">Siswa · Jurnal · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">Jurnal</span></h1>
                <p class="hero-sub">Perbarui catatan kegiatan {{ $siswa->nama }}.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('userSiswa.jurnal', ['id_siswa' => $siswa->id]) }}" class="btn btn--ghost">Batal</a>
                <button class="btn btn--primary" type="submit">Simpan perubahan</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data jurnal</span>
                        <h2 class="card-title">Edit jurnal</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="tanggal">Tanggal <span class="req">*</span></label>
                        <input class="input" id="tanggal" type="date" name="tanggal"
                            value="{{ old('tanggal', $jurnal->tanggal) }}" required>
                        @error('tanggal')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field" style="grid-column:1 / -1">
                        <label class="field-label" for="kegiatan">Kegiatan <span class="req">*</span></label>
                        <textarea class="input" id="kegiatan" name="kegiatan" rows="5" maxlength="255" required>{{ old('kegiatan', $jurnal->kegiatan) }}</textarea>
                        @error('kegiatan')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
