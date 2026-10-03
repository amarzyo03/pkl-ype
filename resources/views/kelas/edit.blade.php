@extends('app')
@section('content')
    <form action="{{ route('kelas.update', $kelas->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · Kelas · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">Kelas</span></h1>
                <p class="hero-sub">Form for editing an existing class in the system.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('kelas') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Update changes</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Class data</span>
                        <h2 class="card-title">Edit Kelas</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="tingkat">Tingkat
                            <span class="req">*</span>
                        </label>
                        <select id="tingkat" class="select" name="tingkat" required>
                            <option value="X" {{ old('tingkat', $tingkat) == 'X' ? 'selected' : '' }}>X</option>
                            <option value="XI" {{ old('tingkat', $tingkat) == 'XI' ? 'selected' : '' }}>XI</option>
                            <option value="XII" {{ old('tingkat', $tingkat) == 'XII' ? 'selected' : '' }}>XII</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label" for="id_jurusan">Jurusan
                            <span class="req">*</span>
                        </label>
                        <select id="id_jurusan" class="select" name="id_jurusan" required>
                            @foreach ($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}"
                                    {{ old('id_jurusan', $kelas->id_jurusan) == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label" for="nomor">Nomor
                            <span class="req">*</span>
                        </label>
                        <input id="nomor" class="input" type="number" name="nomor"
                            value="{{ old('nomor', $nomor) }}" min="1" max="10" placeholder="1-10" required>
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
