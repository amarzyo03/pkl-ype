<form action="{{ isset($pendaftaran) ? route('pendaftaran.update', $pendaftaran->id) : route('pendaftaran.save') }}"
    method="POST">
    @csrf
    @if (isset($pendaftaran))
        @method('PUT')
    @endif

    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Master · Pendaftaran · {{ isset($pendaftaran) ? 'Ubah' : 'Tambah' }}</span>
            <h1 class="hero-title">{{ isset($pendaftaran) ? 'Ubah' : 'Tambah' }} <span class="accent">Pendaftaran</span>
            </h1>
            <p class="hero-sub">Pilih siswa dan tempat PKL untuk pendaftaran ini.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('pendaftaran') }}" class="btn btn--ghost">Batal</a>
            <button type="submit" class="btn btn--primary">{{ isset($pendaftaran) ? 'Simpan Perubahan' : 'Simpan' }}</button>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="card-head">
                <div class="card-title-wrap">
                    <span class="eyebrow">Data pendaftaran</span>
                    <h2 class="card-title">{{ isset($pendaftaran) ? 'Ubah Pendaftaran' : 'Pendaftaran Baru' }}</h2>
                </div>
            </div>
            @if (session('success'))
                <p role="status">{{ session('success') }}</p>
            @endif
            <div class="form-grid">
                <div class="field">
                    <label class="field-label" for="id_siswa">Siswa <span class="req">*</span></label>
                    <input id="id_siswa" class="input" type="text" name="id_siswa"
                        value="{{ old('id_siswa', $pendaftaran->id_siswa ?? 1) }}" readonly required>
                    @error('id_siswa')
                        <small role="alert">{{ $message }}</small>
                    @enderror
                </div>
                <div class="field">
                    <label class="field-label" for="id_dudi">DUDI <span class="req">*</span></label>
                    <select id="id_dudi" class="select" name="id_dudi" required>
                        <option value="">Pilih DUDI</option>
                        @foreach ($dudis as $row)
                            <option value="{{ $row->id }}" @selected((string) old('id_dudi', $pendaftaran->id_dudi ?? '') === (string) $row->id)>
                                {{ $row->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_dudi')
                        <small role="alert">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>
    </div>
</form>
