@extends('app')
@section('content')
    <form action="{{ route('jurusan.update', $jurusan->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · Jurusan · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">Jurusan</span></h1>
                <p class="hero-sub">Form for editing an existing major in the system.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('jurusan') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Update changes</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Study program data</span>
                        <h2 class="card-title">Edit Jurusan</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="kode">Kode
                            <span class="req">*</span>
                        </label>
                        <input id="kode" class="input" type="text" name="kode"
                            value="{{ old('kode', $jurusan->kode) }}" placeholder="Kode Jurusan" autofocus required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="nama">Nama Jurusan
                            <span class="req">*</span>
                        </label>
                        <input id="nama" class="input" type="text" name="nama"
                            value="{{ old('nama', $jurusan->nama) }}" placeholder="Nama Jurusan" required>
                    </div>
                </div>

                <div class="form-actions">
                    <span class="badge dot secondary">Please check the data before saving.</span>
                    <span class="spacer"></span>
                </div>
            </section>
        </div>
    </form>
@endsection
