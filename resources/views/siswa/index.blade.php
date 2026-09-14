@extends('app')
@section('content')
    <style>
        .btn--icon-delete {
            color: #ef4444;
        }

        .btn--icon-delete:hover {
            background: rgba(239, 68, 68, 0.12);
            color: #b91c1c;
        }
    </style>

    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · Siswa</span>
            <h1 class="hero-title">Data <span class="accent">Siswa</span></h1>
            <p class="hero-sub">Manajemen Data Siswa</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('siswa.import') }}" class="btn btn--ghost"><svg viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="M7 10l5 5 5-5" />
                    <path d="M12 15V3" />
                </svg> Import
            </a>
            <a href="{{ route('siswa.add') }}" class="btn btn--primary">
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg> Add siswa
            </a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="data-toolbar">
                <div class="data-toolbar-left">
                    <div class="input-icon" style="flex:1;max-width:420px">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input id="siswa-search" class="input" type="search" name="search"
                            placeholder="Search siswa by NIS, NISN, name, class, username, or ID..."
                            value="{{ request('search', '') }}">
                    </div>
                </div>
                <div class="data-toolbar-right">
                    <select id="siswa-status" class="select" name="status"
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
                            <th>NIS</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="siswa-table-body">
                        @include('siswa.partials.siswa_rows', ['siswas' => $siswas])
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info" id="siswa-summary">
                    @include('siswa.partials.siswa_summary', ['siswas' => $siswas])
                </div>
                <div class="pager" id="siswa-pager">
                    @include('siswa.partials.siswa_pager', ['siswas' => $siswas])
                </div>
            </div>
        </section>
    </div>

    <script>
        const siswaIndexUrl = "{{ route('siswa') }}";
        const searchInput = document.getElementById('siswa-search');
        const statusSelect = document.getElementById('siswa-status');

        const tableBody = document.getElementById('siswa-table-body');
        const summaryContainer = document.getElementById('siswa-summary');
        const pagerContainer = document.getElementById('siswa-pager');

        function buildQueryParams(page = 1) {
            const params = new URLSearchParams();
            const search = searchInput.value.trim();
            const status = statusSelect.value;
            const perPage = document.querySelector('[data-per-page]')?.value || '15';

            if (search) {
                params.set('search', search);
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
            const url = `${siswaIndexUrl}?${params.toString()}`;

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

                    const summaryUrl = new URL(siswaIndexUrl, window.location.origin);
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
            if (event.target === statusSelect) {
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
