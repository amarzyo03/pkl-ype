@extends('app')
@section('content')
    <form action="{{ route('guru.save') }}" method="post">
        @csrf

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · Guru · Add</span>
                <h1 class="hero-title">Tambah <span class="accent">Guru</span></h1>
                <p class="hero-sub">Tambahkan nama guru dan pilih jurusannya.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('guru') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Save changes</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data guru</span>
                        <h2 class="card-title">Tambah Guru</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="nama">Nama <span class="req">*</span></label>
                        <input id="nama" class="input" name="nama" value="{{ old('nama') }}" maxlength="255"
                            required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="id_jurusan">Jurusan <span class="req">*</span></label>
                        <select id="id_jurusan" class="select" name="id_jurusan" required>
                            <option value="">Pilih jurusan</option>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" @selected((string) old('id_jurusan') === (string) $jurusan->id)>
                                    {{ $jurusan->kode }} - {{ $jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
