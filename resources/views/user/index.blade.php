@extends('app')
@section('content')
    <style>
        .badge.user-role-admin {
            background: rgba(239, 68, 68, 0.14);
            color: #b91c1c;
            border-color: rgba(239, 68, 68, 0.35);
        }

        .badge.user-role-guru {
            background: rgba(59, 130, 246, 0.14);
            color: #1d4ed8;
            border-color: rgba(59, 130, 246, 0.35);
        }

        .badge.user-role-siswa {
            background: rgba(245, 158, 11, 0.14);
            color: #b45309;
            border-color: rgba(245, 158, 11, 0.35);
        }

        .btn--icon-delete {
            color: #ef4444;
        }

        .btn--icon-delete:hover {
            background: rgba(239, 68, 68, 0.12);
            color: #b91c1c;
        }
    </style>

    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · Users</span>
            <h1 class="hero-title">Data <span class="accent">Users</span></h1>
            <p class="hero-sub">Manajemen User Aplikasi</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('user.import') }}" class="btn btn--ghost"><svg viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="M7 10l5 5 5-5" />
                    <path d="M12 15V3" />
                </svg> Import
            </a>
            <a href="{{ route('user.add') }}" class="btn btn--primary">
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
                        <input id="user-search" class="input" type="search" name="search"
                            placeholder="Search users by name, email, or ID..." value="{{ request('search', '') }}">
                    </div>
                </div>
                <div class="data-toolbar-right">
                    <select id="user-role" class="select" name="role"
                        style="width:auto;padding:7px 28px 7px 10px;font-size:12px">
                        <option value="all" {{ request('role', 'all') === 'all' ? 'selected' : '' }}>All roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ request('role') === 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ request('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                    <select id="user-status" class="select" name="status"
                        style="width:auto;padding:7px 28px 7px 10px;font-size:12px">
                        <option value="all" {{ request('status', 'all') === 'all' ? 'selected' : '' }}>All status
                        </option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                    <tbody id="user-table-body">
                        @include('user.partials.user_rows', ['users' => $users])
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info" id="user-summary">
                    @include('user.partials.user_summary', ['users' => $users])
                </div>
                <div class="pager" id="user-pager">
                    @include('user.partials.user_pager', ['users' => $users])
                </div>
            </div>
        </section>
    </div>

    <script>
        const userIndexUrl = "{{ route('user') }}";
        const searchInput = document.getElementById('user-search');
        const roleSelect = document.getElementById('user-role');
        const statusSelect = document.getElementById('user-status');

        const tableBody = document.getElementById('user-table-body');
        const summaryContainer = document.getElementById('user-summary');
        const pagerContainer = document.getElementById('user-pager');

        function buildQueryParams(page = 1) {
            const params = new URLSearchParams();
            const search = searchInput.value.trim();
            const role = roleSelect.value;
            const status = statusSelect.value;
            const perPage = document.querySelector('[data-per-page]')?.value || '15';

            if (search) {
                params.set('search', search);
            }

            if (role && role !== 'all') {
                params.set('role', role);
            }

            if (status && status !== 'all') {
                params.set('status', status);
            }

            params.set('perPage', perPage);
            params.set('page', page);
            params.set('ajax', '1');

            return params;
        }

        function updateList(page = 1) {
            const params = buildQueryParams(page);
            const url = `${userIndexUrl}?${params.toString()}`;

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = data.rows;
                    summaryContainer.innerHTML = data.summary;
                    pagerContainer.innerHTML = data.pager;

                    const summaryUrl = new URL(userIndexUrl, window.location.origin);
                    summaryUrl.search = params.toString().replace(/&ajax=1/g, '');
                    history.replaceState({}, '', summaryUrl.toString().replace(window.location.origin, ''));
                })
                .catch(error => {
                    console.error(error);
                });
        }

        let searchTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => updateList(1), 300);
        });

        document.addEventListener('change', function(event) {
            if (event.target === roleSelect || event.target === statusSelect) {
                updateList(1);
            }

            if (event.target.matches('[data-per-page]')) {
                updateList(1);
            }
        });

        document.addEventListener('click', function(event) {
            const paginationButton = event.target.closest('[data-page]');
            if (!paginationButton) {
                return;
            }

            event.preventDefault();
            updateList(paginationButton.dataset.page);
        });
    </script>
@endsection
