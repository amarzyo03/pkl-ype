@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · Jurusan</span>
            <h1 class="hero-title">Data <span class="accent">Jurusan</span></h1>
            <p class="hero-sub">Manajemen Data Jurusan</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('jurusan.import') }}" class="btn btn--ghost"><svg viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="M7 10l5 5 5-5" />
                    <path d="M12 15V3" />
                </svg> Import
            </a>
            <a href="{{ route('jurusan.add') }}" class="btn btn--primary">
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg> Add jurusan
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
                        <input id="jurusan-search" class="input" type="search" name="search"
                            placeholder="Search jurusan by code, name, or ID..." value="{{ request('search', '') }}">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px"> # </th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="jurusan-table-body">
                        @include('jurusan.partials.jurusan_rows', ['jurusans' => $jurusans])
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info" id="jurusan-summary">
                    @include('jurusan.partials.jurusan_summary', ['jurusans' => $jurusans])
                </div>
                <div class="pager" id="jurusan-pager">
                    @include('jurusan.partials.jurusan_pager', ['jurusans' => $jurusans])
                </div>
            </div>
        </section>
    </div>

    <script>
        const jurusanIndexUrl = "{{ route('jurusan') }}";
        const searchInput = document.getElementById('jurusan-search');
        const tableBody = document.getElementById('jurusan-table-body');
        const summaryContainer = document.getElementById('jurusan-summary');
        const pagerContainer = document.getElementById('jurusan-pager');

        function buildQueryParams(page = 1) {
            const params = new URLSearchParams();
            const search = searchInput.value.trim();
            const perPage = document.querySelector('[data-per-page]')?.value || '15';

            if (search) {
                params.set('search', search);
            }

            params.set('perPage', perPage);
            params.set('page', page);
            params.set('ajax', '1');

            return params;
        }

        function updateList(page = 1) {
            const params = buildQueryParams(page);
            const url = `${jurusanIndexUrl}?${params.toString()}`;

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

                    const summaryUrl = new URL(jurusanIndexUrl, window.location.origin);
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
