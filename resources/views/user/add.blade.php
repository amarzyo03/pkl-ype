@extends('app')
@section('content')
    <form action="{{ route('user.save') }}" method="post">
        @csrf

        <section class="hero">
            <div class="hero-text"><span class="eyebrow">Master · User · Add</span>
                <h1 class="hero-title">Add <span class="accent">User</span></h1>
                <p class="hero-sub">Form for adding a new user to the system.</p>
            </div>
            <div class="hero-actions">
                <a href="{{ route('user') }}" class="btn btn--ghost">Cancel</a>
                <button class="btn btn--primary" type="submit">Save changes</button>
            </div>
        </section>

        <div class="grid">

            <section class="col-12 card">
                <div class="card-head">
                    <div class="card-title-wrap">
                        <span class="eyebrow">User for login</span>
                        <h2 class="card-title">Add New User</h2>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label class="field-label" for="nama">Name
                            <span class="req">*</span>
                        </label>
                        <input id="nama" class="input" type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="Nama Lengkap" autofocus required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="username">Username
                            <span class="req">*</span>
                        </label>
                        <input id="username" class="input" type="text" name="username" value="{{ old('username') }}"
                            placeholder="Username" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="password">Password
                            <span class="req">*</span>
                        </label>
                        <input id="password" class="input" type="password" name="password" placeholder="Password"
                            required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="password_confirmation">Confirm Password
                            <span class="req">*</span>
                        </label>
                        <input id="password_confirmation" class="input" type="password" name="password_confirmation"
                            placeholder="Confirm Password" required>
                    </div>
                    <div class="field">
                        <label class="field-label" for="role">Role
                            <span class="req">*</span>
                        </label>
                        <select id="role" class="select" name="role">
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="field-label" for="status">Status
                            <span class="req">*</span>
                        </label>
                        <select id="status" class="select" name="status">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
