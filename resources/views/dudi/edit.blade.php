@extends('app')
@section('content')
    <form action="{{ route('dudi.update', $dudi->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · DUDI · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">DUDI</span></h1>
                <p class="hero-sub">Perbarui informasi mitra dan pembimbingnya.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('dudi') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Update changes</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data mitra</span>
                        <h2 class="card-title">Edit DUDI</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="nama">Nama DUDI <span class="req">*</span></label>
                        <input id="nama" class="input" name="nama" value="{{ old('nama', $dudi->nama) }}"
                            maxlength="255" required>
                        @error('nama') <span class="text-muted">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="alamat">Alamat <span class="req">*</span></label>
                        <input id="alamat" class="input" name="alamat" value="{{ old('alamat', $dudi->alamat) }}"
                            maxlength="255" required>
                        @error('alamat') <span class="text-muted">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="telp">Telepon <span class="req">*</span></label>
                        <input id="telp" class="input" name="telp" value="{{ old('telp', $dudi->telp) }}"
                            maxlength="30" required>
                        @error('telp') <span class="text-muted">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="pic">PIC <span class="req">*</span></label>
                        <input id="pic" class="input" name="pic" value="{{ old('pic', $dudi->pic) }}"
                            maxlength="255" required>
                        @error('pic') <span class="text-muted">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="id_jurusan">Jurusan <span class="req">*</span></label>
                        <select id="id_jurusan" class="select" name="id_jurusan" required>
                            <option value="">Pilih jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}"
                                    {{ (string) old('id_jurusan', $dudi->id_jurusan) === (string) $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->kode }} - {{ $jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_jurusan') <span class="text-muted">{{ $message }}</span> @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="id_guru">Guru pembimbing <span class="req">*</span></label>
                        <select id="id_guru" class="select" name="id_guru" required>
                            <option value="">Pilih guru</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ (string) old('id_guru', $dudi->id_guru) === (string) $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_guru') <span class="text-muted">{{ $message }}</span> @enderror
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
