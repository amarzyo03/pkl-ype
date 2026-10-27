@extends('app')
@section('content')
    <style>
        .registration-page {
            margin: 0 auto;
            width: 100%;
        }

        .registration-page .registration-submit {
            align-self: flex-center;
            justify-content: center;
            margin-top: 22px;
            min-width: 120px;
        }

        @media (max-width: 720px) {
            .registration-page .registration-submit {
                align-self: stretch;
                width: 100%;
            }
        }
    </style>

    <div class="registration-page">
        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Siswa · Pendaftaran · PKL</span>
                <h1 class="hero-title">Pendaftaran Lokasi Tempat <span class="accent"> PKL</span></h1>
                <p class="hero-sub">Silahkan pilih dudi untuk mendaftar di tempat PKL yang tersedia.</p>
            </div>
            {{-- <div class="hero-actions">
                <a href="{{ route('dudi') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Save changes</button>
            </div> --}}
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Daftar DUDI Tersedia</span>
                        <h2 class="card-title">PENDAFTARAN LOKASI TEMPAT PKL</h2>
                    </div>
                </div>
                @if (session('success'))
                    <p role="status">{{ session('success') }}</p>
                @endif
                <form action="{{ route('userSiswa.pendaftaran.attempt') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="field">
                            <label class="field-label" for="nama">NAMA<span class="req">*</span></label>
                            <input class="input" type="hidden" id="nama" name="nama" value="{{ $siswa->id }}">
                            <input class="input" type="text" value="{{ strtoupper($siswa->nama) }}" readonly>
                        </div>
                        <div class="field">
                            <label class="field-label" for="dudi">DAFTAR DUDI <span class="req">*</span></label>
                            <select id="dudi" class="input" name="dudi" required>
                                <option value="">.:: Pilih DUDI ::.</option>
                                @foreach ($dudi as $i => $row)
                                    <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
                            @error('dudi')
                                <small role="alert">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn--primary registration-submit" type="submit">DAFTAR</button>
                </form>
            </section>
        </div>
    </div>
@endsection
