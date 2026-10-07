@extends('app')
@section('content')
    <form action="{{ route('guru.save') }}" method="post">
        @csrf

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · Guru · Add</span>
                <h1 class="hero-title">Tambah <span class="accent">Guru</span></h1>
                <p class="hero-sub">Tambahkan akun guru untuk masuk ke aplikasi.</p>
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
                        <span class="eyebrow">Akun guru</span>
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
                        <label class="field-label" for="username">Username <span class="req">*</span></label>
                        <input id="username" class="input" name="username" value="{{ old('username') }}" maxlength="255"
                            required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="password">Password <span class="req">*</span></label>
                        <input id="password" class="input" type="password" name="password" minlength="8" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="password_confirmation">Konfirmasi Password <span
                                class="req">*</span></label>
                        <input id="password_confirmation" class="input" type="password" name="password_confirmation"
                            minlength="8" required>
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
