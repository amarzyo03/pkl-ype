@extends('app')
@section('content')
    <form action="{{ route('siswa.update', $siswa->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · Siswa · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">Siswa</span></h1>
                <p class="hero-sub">Form for editing an existing student in the system.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('siswa') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Update changes</button>
            </div>
        </section>

        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">Student data</span>
                        <h2 class="card-title">Edit Siswa</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="nis">NIS
                            <span class="req">*</span>
                        </label>
                        <input id="nis" class="input" type="text" name="nis"
                            value="{{ old('nis', $siswa->nis) }}" placeholder="NIS" autofocus required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="nisn">NISN
                            <span class="req">*</span>
                        </label>
                        <input id="nisn" class="input" type="text" name="nisn"
                            value="{{ old('nisn', $siswa->nisn) }}" placeholder="NISN" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="nama">Nama
                            <span class="req">*</span>
                        </label>
                        <input id="nama" class="input" type="text" name="nama"
                            value="{{ old('nama', $siswa->nama) }}" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="kelas">Kelas
                            <span class="req">*</span>
                        </label>
                        <input id="kelas" class="input" type="text" name="kelas"
                            value="{{ old('kelas', $siswa->kelas) }}" placeholder="Kelas" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="username">Username
                            <span class="req">*</span>
                        </label>
                        <input id="username" class="input" type="text" name="username"
                            value="{{ old('username', $siswa->username) }}" placeholder="Username" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <input id="password" class="input" type="password" name="password"
                            placeholder="Leave blank to keep current password">
                    </div>
                    <div class="field">
                        <label class="field-label" for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" class="input" type="password" name="password_confirmation"
                            placeholder="Confirm new password">
                    </div>
                    <div class="field">
                        <label class="field-label" for="status">Status
                            <span class="req">*</span>
                        </label>
                        <select id="status" class="select" name="status">
                            <option value="active" {{ old('status', $siswa->status) == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ old('status', $siswa->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
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
