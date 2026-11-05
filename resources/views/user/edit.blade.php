@extends('app')
@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · User · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">User</span></h1>
                <p class="hero-sub">Form for editing an existing user in the system.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('user') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Update changes</button>
            </div>
        </section>
        <div class="grid">
            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">User for login</span>
                        <h2 class="card-title">Edit User</h2>
                    </div>
                </div>
                <div class="form-grid">
                    @if ($errors->any())
                        <div class="col-12" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif
                    <div class="field" id="guru-profile-field">
                        <label class="field-label" for="id_guru">Guru
                            <span class="req">*</span>
                        </label>
                        <select id="id_guru" class="select" name="id_guru">
                            <option value="">Pilih guru</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}"
                                    @selected(old('id_guru', $user->role !== 'siswa' ? $user->id_user : '') == $guru->id)>
                                    {{ $guru->nama }} —
                                    {{ $guru->jurusan
                                        ? $guru->jurusan->kode . ' - ' . $guru->jurusan->nama
                                        : 'Jurusan tidak tersedia' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field" id="siswa-profile-field" hidden>
                        <label class="field-label" for="id_siswa">Siswa
                            <span class="req">*</span>
                        </label>
                        <select id="id_siswa" class="select" name="id_siswa" disabled>
                            <option value="">Pilih siswa</option>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}"
                                    @selected(old('id_siswa', $user->role === 'siswa' ? $user->id_user : '') == $siswa->id)>
                                    {{ $siswa->nama }} — {{ $siswa->nis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label" for="username">Username
                            <span class="req">*</span>
                        </label>
                        <input id="username" class="input" type="text" name="username"
                            value="{{ old('username', $user->username) }}" placeholder="Username" required>
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
                        <label class="field-label" for="role">Role
                            <span class="req">*</span>
                        </label>
                        <select id="role" class="select" name="role" required>
                            <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                            <option value="guru" @selected(old('role', $user->role) === 'guru')>Guru</option>
                            <option value="siswa" @selected(old('role', $user->role) === 'siswa')>Siswa</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label" for="status">Status
                            <span class="req">*</span>
                        </label>
                        <select id="status" class="select" name="status">
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <span class="badge dot secondary">Please check the data before saving.
                    </span> <span class="spacer"></span>
                </div>
            </section>
        </div>
    </form>
    <script>
        const roleSelect = document.getElementById('role');
        const guruField = document.getElementById('guru-profile-field');
        const siswaField = document.getElementById('siswa-profile-field');
        const guruSelect = document.getElementById('id_guru');
        const siswaSelect = document.getElementById('id_siswa');

        function updateProfileFields() {
            const isStudent = roleSelect.value === 'siswa';
            guruField.hidden = isStudent;
            guruSelect.disabled = isStudent;
            guruSelect.required = !isStudent;
            siswaField.hidden = !isStudent;
            siswaSelect.disabled = !isStudent;
            siswaSelect.required = isStudent;
        }

        roleSelect.addEventListener('change', updateProfileFields);
        updateProfileFields();
    </script>
@endsection
