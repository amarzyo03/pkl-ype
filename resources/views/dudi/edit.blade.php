@extends('app')
@section('content')
    <form action="{{ route('dudi.update', $dudi->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · DUDI · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">DUDI</span></h1>
                <p class="hero-sub">Perbarui informasi mitra dunia usaha atau dunia industri.</p>
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
                    </div>
                    <div class="field">
                        <label class="field-label" for="bidang_usaha">Bidang Usaha</label>
                        <input id="bidang_usaha" class="input" name="bidang_usaha"
                            value="{{ old('bidang_usaha', $dudi->bidang_usaha) }}" maxlength="255">
                    </div>
                    <div class="field">
                        <label class="field-label" for="telepon">Telepon</label>
                        <input id="telepon" class="input" type="tel" name="telepon"
                            value="{{ old('telepon', $dudi->telepon) }}" maxlength="30">
                    </div>
                    <div class="field">
                        <label class="field-label" for="email">Email</label>
                        <input id="email" class="input" type="email" name="email"
                            value="{{ old('email', $dudi->email) }}" maxlength="255">
                    </div>
                    <div class="field" style="grid-column:1 / -1">
                        <label class="field-label" for="alamat">Alamat</label>
                        <textarea id="alamat" class="input" name="alamat" rows="3">{{ old('alamat', $dudi->alamat) }}</textarea>
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
