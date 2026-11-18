@extends('app')
@section('content')
    <form action="{{ route('mapping.update', $mapping->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · Mapping Guru · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">Mapping</span></h1>
                <p class="hero-sub">Perbarui penugasan guru, mata pelajaran, atau kelas.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('mapping.index') }}" class="btn btn--ghost">Kembali</a>
                <button class="btn btn--primary" type="submit">Simpan perubahan</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data pengajaran</span>
                        <h2 class="card-title">Edit Mapping Guru</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="id_guru">Guru <span class="req">*</span></label>
                        <select id="id_guru" class="select" name="id_guru" required>
                            <option value="">Pilih guru</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}"
                                    {{ old('id_guru', $mapping->id_guru) == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama }}{{ $guru->trashed() ? ' (nonaktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_guru')
                            <span class="badge dot danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="id_mapel">Mata Pelajaran <span class="req">*</span></label>
                        <select id="id_mapel" class="select" name="id_mapel" required>
                            <option value="">Pilih mata pelajaran</option>
                            @foreach ($mapels as $mapel)
                                <option value="{{ $mapel->id }}"
                                    {{ old('id_mapel', $mapping->id_mapel) == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->kode }} — {{ $mapel->nama }}{{ $mapel->trashed() ? ' (nonaktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_mapel')
                            <span class="badge dot danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="id_kelas">Kelas <span class="req">*</span></label>
                        <select id="id_kelas" class="select" name="id_kelas" required>
                            <option value="">Pilih kelas</option>
                            @foreach ($kelas as $kelasOption)
                                <option value="{{ $kelasOption->id }}"
                                    {{ old('id_kelas', $mapping->id_kelas) == $kelasOption->id ? 'selected' : '' }}>
                                    {{ $kelasOption->nama }}{{ $kelasOption->trashed() ? ' (nonaktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kelas')
                            <span class="badge dot danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
