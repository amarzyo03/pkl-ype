@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Siswa · PKL · Status</span>
            <h1 class="hero-title">Status Pendaftaran <span class="accent"> PKL</span></h1>
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
                    <h2 class="card-title">Informasi Status Pendaftaran</h2>
                </div>
            </div>
            @if ($siswa)
                @if (session('success'))
                    <p role="status">{{ session('success') }}</p>
                @endif
                <div class="form-grid">
                    <div class="field">
                        <span class="field-label">NAMA</span>
                        <p>{{ ucwords($siswa->nama) }}</p>
                    </div>
                    <div class="field">
                        <span class="field-label">KELAS</span>
                        <p>{{ strtoupper($siswa->kelas->nama ?? 'Tidak ada kelas') }}</p>
                    </div>
                    <div class="field">
                        <span class="field-label">DUDI</span>
                        <p>{{ strtoupper($siswa->pendaftaran->dudi->nama ?? 'Tidak ada DUDI') }}</p>
                    </div>
                    <div class="field">
                        <span class="field-label">Status Pendaftaran</span>
                        <p>
                            <span class="badge warning dot">{{ strtoupper($siswa->pendaftaran->status) }}</span>
                        </p>
                    </div>
                </div>
                <a href="{{ route('userSiswa.pendaftaran.edit') }}" class="btn btn--primary" style="margin-top: 22px;">Ubah
                    DUDI</a>
            @else
                <p class="text-muted">Belum ada pendaftaran dengan data siswa yang sesuai.</p>
            @endif
        </section>
    </div>
@endsection
