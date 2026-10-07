@extends('app')
@section('content')
    <form action="{{ route('guru.update', $guru->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · Guru · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">Guru</span></h1>
                <p class="hero-sub">Perbarui informasi akun guru.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('guru') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Update changes</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Akun guru</span>
                        <h2 class="card-title">Edit Guru</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="nama">Nama <span class="req">*</span></label>
                        <input id="nama" class="input" name="nama" value="{{ old('nama', $guru->nama) }}"
                            maxlength="255" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="username">Username <span class="req">*</span></label>
                        <input id="username" class="input" name="username" value="{{ old('username', $guru->username) }}"
                            maxlength="255" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="password">Password baru</label>
                        <input id="password" class="input" type="password" name="password" minlength="8"
                            placeholder="Kosongkan untuk mempertahankan password">
                    </div>
                    <div class="field">
                        <label class="field-label" for="password_confirmation">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" class="input" type="password" name="password_confirmation"
                            minlength="8">
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
