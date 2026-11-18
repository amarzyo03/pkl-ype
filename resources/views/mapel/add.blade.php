@extends('app')
@section('content')
    <form action="{{ route('mapel.save') }}" method="post">
        @csrf

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · Mata Pelajaran · Add</span>
                <h1 class="hero-title">Tambah <span class="accent">Mata Pelajaran</span></h1>
                <p class="hero-sub">Form untuk menambahkan mata pelajaran baru.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('mapel') }}" class="btn btn--ghost">Batal</a>
                <button class="btn btn--primary" type="submit">Simpan</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data mata pelajaran</span>
                        <h2 class="card-title">Mata Pelajaran Baru</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="kode">Kode <span class="req">*</span></label>
                        <input id="kode" class="input" type="text" name="kode" value="{{ old('kode') }}"
                            placeholder="Kode mata pelajaran" required autofocus>
                    </div>
                    <div class="field">
                        <label class="field-label" for="nama">Nama <span class="req">*</span></label>
                        <input id="nama" class="input" type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="Nama mata pelajaran" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="jenis">Jenis <span class="req">*</span></label>
                        <select id="jenis" class="select" name="jenis" required>
                            <option value="">Pilih jenis</option>
                            <option value="skk" {{ old('jenis') === 'skk' ? 'selected' : '' }}>SKK</option>
                            <option value="produktif" {{ old('jenis') === 'produktif' ? 'selected' : '' }}>Produktif
                            </option>
                        </select>
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
