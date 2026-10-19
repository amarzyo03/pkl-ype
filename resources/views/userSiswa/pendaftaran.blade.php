@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow" id="heroDate">Thursday · April 23 · 2026</span>
            <h1 class="hero-title">Pendaftaran Tempat<span class="accent"> PKL</span></h1>
            <p class="hero-sub">Silahkan isi formulir di bawah ini untuk mendaftar di tempat PKL yang tersedia.</p>
        </div>
    </section>


    @if (session('success'))
        <p role="status">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p role="alert">{{ session('error') }}</p>
    @endif

    @if ($pendaftaran && !$isEditing)
        <section aria-live="polite">
            <p>Anda telah mendaftar di tempat PKL di: <br><strong>{{ $pendaftaran->dudi }}</strong>.</p>
            <p>Nama: <strong>{{ $pendaftaran->nama }}</strong></p>
            <div class="hero-actions">
                <a class="btn btn--primary" href="{{ route('userSiswa.pendaftaran.edit') }}">Ubah</a>
                <form action="{{ route('userSiswa.pendaftaran.cancel') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn--ghost" type="submit">Batalkan</button>
                </form>
            </div>
        </section>
    @else
        <form class="auth-form"
            action="{{ $isEditing ? route('userSiswa.pendaftaran.update') : route('userSiswa.pendaftaran.save') }}"
            method="post">
            @csrf
            @if ($isEditing)
                @method('PUT')
            @endif

            <div class="field">
                <label class="field-label" for="nama">Nama</label>
                <input class="input" id="nama" name="nama" type="text"
                    value="{{ old('nama', $pendaftaran?->nama) }}" maxlength="255" required>
                @error('nama')
                    <small role="alert">{{ $message }}</small>
                @enderror
            </div>

            <div class="field">
                <label class="field-label" for="dudi">Tempat PKL</label>
                <select class="select" id="dudi" name="dudi" required>
                    <option value="">Pilih tempat PKL</option>
                    @foreach ($dudis as $dudi)
                        <option value="{{ $dudi->nama }}"
                            {{ old('dudi', $pendaftaran?->dudi) === $dudi->nama ? 'selected' : '' }}>
                            {{ $dudi->nama }}
                        </option>
                    @endforeach
                </select>
                @error('dudi')
                    <small role="alert">{{ $message }}</small>
                @enderror
            </div>

            <div class="hero-actions">
                <button class="btn btn--primary" type="submit">
                    {{ $isEditing ? 'Simpan perubahan' : 'Daftar' }}
                </button>
                @if ($isEditing)
                    <a class="btn btn--ghost" href="{{ route('userSiswa.pendaftaran') }}">Kembali</a>
                @endif
            </div>
        </form>
    @endif
@endsection
