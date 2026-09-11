@extends('app')
@section('content')
    <form action="{{ route('auth.update', $user->id) }}" method="post">
        @csrf
        @method('PUT')

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · User · Edit</span>
                <h1 class="hero-title">Edit <span class="accent">User</span></h1>
                <p class="hero-sub">Form for editing an existing user in the system.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('auth') }}" class="btn btn--ghost">Cancel</a>
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
                    <div class="field">
                        <label class="field-label" for="nama">Name
                            <span class="req">*</span>
                        </label>
                        <input id="nama" class="input" type="text" name="nama"
                            value="{{ old('nama', $user->nama) }}" placeholder="Nama Lengkap" autofocus required>
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
                        <select id="role" class="select" name="role">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa
                            </option>
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
@endsection
