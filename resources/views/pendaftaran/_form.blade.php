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
            <p class="hero-sub">Tentukan siswa, tempat PKL, dan status pendaftarannya.</p>
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
            <div class="form-grid">
                <div class="field">
                    <label class="field-label" for="id_siswa">Siswa <span class="req">*</span></label>
                    <select id="id_siswa" class="select" name="id_siswa" required>
                        <option value="">Pilih siswa</option>
                        @foreach ($siswas as $siswa)
                            <option value="{{ $siswa->id }}" @selected((string) old('id_siswa', $pendaftaran->id_siswa ?? '') === (string) $siswa->id)>
                                {{ $siswa->nama }} ({{ $siswa->nis }})
                            </option>
                        @endforeach
                    </select>
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
                <div class="field">
                    <label class="field-label" for="status">Status <span class="req">*</span></label>
                    <select id="status" class="select" name="status" required>
                        @foreach (['pending' => 'Pending', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $pendaftaran->status ?? 'pending') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <small role="alert">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </section>
    </div>
</form>
