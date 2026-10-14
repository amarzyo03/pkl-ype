@extends('app')
@section('content')
    <form action="{{ route('tugas.update', $tugas->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Tugas · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">Tugas</span></h1>
                <p class="hero-sub">Perbarui informasi dan lampiran tugas.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('tugas') }}" class="btn btn--ghost">Batal</a>
                <button class="btn btn--primary" type="submit">Simpan perubahan</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data tugas</span>
                        <h2 class="card-title">Edit tugas</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="pengirim">Pengirim <span class="req">*</span></label>
                        <input id="pengirim" class="input" name="pengirim" value="{{ old('pengirim', $tugas->pengirim) }}"
                            maxlength="255" required>
                        @error('pengirim')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="judul">Judul <span class="req">*</span></label>
                        <input id="judul" class="input" name="judul" value="{{ old('judul', $tugas->judul) }}"
                            maxlength="255" required>
                        @error('judul')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field" style="grid-column:1 / -1">
                        <label class="field-label" for="deskripsi">Deskripsi <span class="req">*</span></label>
                        <textarea id="deskripsi" class="input" name="deskripsi" rows="5" required>{{ old('deskripsi', $tugas->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field" style="grid-column:1 / -1">
                        <label class="field-label" for="file">Ganti lampiran</label>
                        <p><a href="{{ route('tugas.file', $tugas->id) }}">Unduh lampiran saat ini</a></p>
                        <input id="file" class="input" type="file" name="file"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.txt">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti lampiran. Maksimal 20 MB.</small>
                        @error('file')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
