@extends('app')
@section('content')
    <form action="{{ route('pendaftaran.update', $pendaftaran->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Pendaftaran · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">Pendaftaran</span></h1>
                <p class="hero-sub">Perbarui data pendaftaran.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('pendaftaran') }}" class="btn btn--ghost">Batal</a>
                <button class="btn btn--primary" type="submit">Simpan perubahan</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Data pendaftaran</span>
                        <h2 class="card-title">Edit pendaftaran</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="nama">Nama <span class="req">*</span></label>
                        <input id="nama" class="input" name="nama" value="{{ old('nama', $pendaftaran->nama) }}"
                            maxlength="255" required>
                        @error('nama')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="field-label" for="dudi">DUDI <span class="req">*</span></label>
                        <select id="dudi" class="select" name="dudi" required>
                            <option value="">Pilih DUDI</option>
                            @foreach ($dudis as $dudi)
                                <option value="{{ $dudi->nama }}"
                                    {{ old('dudi', $pendaftaran->dudi) === $dudi->nama ? 'selected' : '' }}>
                                    {{ $dudi->nama }}</option>
                            @endforeach
                        </select>
                        @error('dudi')
                            <small class="text-muted">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </section>
        </div>
    </form>
@endsection
