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
            <div class="hero-text"><span class="eyebrow">Siswa · Daftar · PKL</span>
                <h1 class="hero-title">Pendaftaran Tempat <span class="accent"> PKL</span></h1>
                <p class="hero-sub">Silahkan isi formulir di bawah ini untuk mendaftar di tempat PKL yang tersedia.</p>
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
                        <span class="eyebrow">Pendaftaran Lokasi Tempat PKL</span>
                        <h2 class="card-title">
                            {{ isset($pendaftaran) ? 'Ubah Tempat PKL' : 'Pendaftaran Lokasi Tempat PKL' }}
                        </h2>
                    </div>
                </div>
                @if (session('success'))
                    <p role="status">{{ session('success') }}</p>
                @endif
                <form
                    action="{{ isset($pendaftaran) ? route('userSiswa.pendaftaran.update') : route('userSiswa.pendaftaran.attempt') }}"
                    method="POST">
                    @csrf
                    @if (isset($pendaftaran))
                        @method('PUT')
                    @endif
                    <div class="form-grid">
                        <div class="field">
                            <label class="field-label" for="nama">Nama Siswa <span class="req">*</span></label>
                            <input id="nama" class="input" name="nama"
                                value="{{ $pendaftaran->siswa->id ?? 1 }}" type="text" readonly>
                            @error('nama')
                                <small role="alert">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="field-label" for="dudi">Nama DUDI <span class="req">*</span></label>
                            <select id="dudi" class="input" name="dudi" required>
                                <option value="">Pilih DUDI</option>
                                @foreach ($dudi as $i => $row)
                                    <option value="{{ $row->id }}" @selected((string) old('dudi', $pendaftaran->id_dudi ?? '') === (string) $row->id)>
                                        {{ $row->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('dudi')
                                <small role="alert">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    @if (isset($pendaftaran))
                        <a href="{{ route('userSiswa.pendaftaran') }}" class="btn btn--ghost registration-submit">Batal</a>
                    @endif
                    <button class="btn btn--primary registration-submit" type="submit">
                        {{ isset($pendaftaran) ? 'Simpan Perubahan' : 'Daftar' }}
                    </button>
                </form>
            </section>
        </div>
    </div>
@endsection
