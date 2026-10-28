<form action="{{ isset($tugas) ? route('tugas.update', $tugas->id) : route('tugas.save') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if (isset($tugas))
        @method('PUT')
    @endif

    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Tugas · {{ isset($tugas) ? 'Edit' : 'Tambah' }}</span>
            <h1 class="hero-title">{{ isset($tugas) ? 'Ubah' : 'Tambah' }} <span class="accent">Tugas</span></h1>
            <p class="hero-sub">Kelola tugas yang diberikan guru kepada siswa.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('tugas') }}" class="btn btn--ghost">Batal</a>
            <button type="submit" class="btn btn--primary">
                {{ isset($tugas) ? 'Simpan Perubahan' : 'Simpan Tugas' }}
            </button>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="card-head">
                <div class="card-title-wrap">
                    <span class="eyebrow">Data tugas</span>
                    <h2 class="card-title">{{ isset($tugas) ? 'Ubah Tugas' : 'Tugas Baru' }}</h2>
                </div>
            </div>
            <div class="form-grid">
                <div class="field">
                    <label class="field-label" for="id_guru">Guru <span class="req">*</span></label>
                    <input type="hidden" class="input" id="id_guru" name="id_guru" value="{{ $guru->id }}">
                    <input type="text" class="input" value="{{ strtoupper($guru->nama) }}" readonly>
                </div>
                <div class="field">
                    <label class="field-label" for="tanggal">Tanggal <span class="req">*</span></label>
                    <input id="tanggal" class="input" type="date" name="tanggal"
                        value="{{ old('tanggal', isset($tugas) ? $tugas->tanggal->format('Y-m-d') : '') }}" required>
                    @error('tanggal')
                        <small role="alert">{{ $message }}</small>
                    @enderror
                </div>
                <div class="field">
                    <label class="field-label" for="judul">Judul <span class="req">*</span></label>
                    <input id="judul" class="input" type="text" name="judul" maxlength="255"
                        value="{{ old('judul', $tugas->judul ?? '') }}" required>
                    @error('judul')
                        <small role="alert">{{ $message }}</small>
                    @enderror
                </div>
                <div class="field">
                    <label class="field-label" for="file">Lampiran</label>
                    <input id="file" class="input" type="file" name="file" accept=".pdf,application/pdf">
                    <small class="text-muted">PDF opsional, maksimal 20 MB.</small>
                    @if (isset($tugas) && $tugas->file)
                        <small>
                            Lampiran saat ini:
                            <a href="{{ route('tugas.file', $tugas->id) }}">{{ basename($tugas->file) }}</a>
                        </small>
                    @endif
                    @error('file')
                        <small role="alert">{{ $message }}</small>
                    @enderror
                </div>
                <div class="field" style="grid-column: 1 / -1">
                    <label class="field-label" for="deskripsi">Deskripsi <span class="req">*</span></label>
                    <textarea id="deskripsi" class="input" name="deskripsi" rows="5" required>{{ old('deskripsi', $tugas->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <small role="alert">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>
    </div>
</form>
