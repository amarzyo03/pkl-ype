@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · Users</span>
            <h1 class="hero-title">Data <span class="accent">Users</span></h1>
            <p class="hero-sub">Manajemen User Aplikasi</p>
        </div>
        <div class="hero-actions">
            <button class="btn btn--ghost"><svg viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="M7 10l5 5 5-5" />
                    <path d="M12 15V3" />
                </svg> Import
            </button>
            <a href="{{ route('auth.add') }}" class="btn btn--primary">
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg> Add user
            </a>
        </div>
    </section>

    <div class="grid">

        <section class="col-12 card">
            <div class="data-toolbar">
                <div class="data-toolbar-left">
                    <div class="input-icon" style="flex:1;max-width:320px">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input class="input" type="search" placeholder="Search users by name, email, or ID...">
                    </div>
                </div>
                <div class="data-toolbar-right">
                    <select class="select" style="width:auto;padding:7px 28px 7px 10px;font-size:12px">
                        <option>All roles</option>
                        <option>Admin</option>
                        <option>Guru</option>
                        <option>Siswa</option>
                    </select>
                    <select class="select" style="width:auto;padding:7px 28px 7px 10px;font-size:12px">
                        <option>All status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px"> # </th>
                            <th class="sorted-asc">User
                                <span class="sort">
                                    <svg viewBox="0 0 24 24">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </span>
                            </th>
                            <th>Role
                                <span class="sort">
                                    <svg viewBox="0 0 24 24">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </span>
                            </th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $i => $row)
                            <tr class="data-row">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="data-cell-user">
                                        <div class="av ma-2">A</div>
                                        <div class="data-cell-user-meta">
                                            <div class="data-cell-user-name">{{ ucwords($row->nama) }}</div>
                                            <div class="data-cell-user-email">{{ strtolower($row->username) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge primary">{{ ucwords($row->role) }}</span></td>
                                <td><span class="badge success dot">{{ ucwords($row->status) }}</span></td>
                                <td>
                                    <div class="data-cell-actions">
                                        <a href="{{ route('auth.edit', $row->id) }}" class="btn--icon" aria-label="Edit"
                                            title="Edit">
                                            <svg viewBox="0 0 24 24">
                                                <path d="M12 20h9" />
                                                <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('auth.delete', $row->id) }}" method="post"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn--icon" aria-label="Delete" title="Delete">
                                                <svg viewBox="0 0 24 24">
                                                    <circle cx="12" cy="5" r="1" />
                                                    <circle cx="12" cy="12" r="1" />
                                                    <circle cx="12" cy="19" r="1" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted"> No users data Found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    <span>Showing <strong style="color:var(--t-base)">1–15</strong> of
                        <strong style="color:var(--t-base)">142</strong>
                    </span>
                    <select class="select">
                        <option>15 per page</option>
                        <option>25 per page</option>
                        <option>50 per page</option>
                        <option>100 per page</option>
                    </select>
                </div>
                <div class="pager">
                    <button class="pager-btn" disabled="disabled" aria-label="Previous">
                        <svg viewBox="0 0 24 24">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                    <button class="pager-btn is-active">1</button>
                    <button class="pager-btn">2</button>
                    <button class="pager-btn">3</button>
                    <button class="pager-btn">…</button>
                    <button class="pager-btn">10</button>
                    <button class="pager-btn" aria-label="Next">
                        <svg viewBox="0 0 24 24">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </button>
                </div>
            </div>

        </section>

    </div>
@endsection
