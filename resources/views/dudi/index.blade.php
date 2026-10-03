@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · DUDI</span>
            <h1 class="hero-title">Data <span class="accent">DUDI</span></h1>
            <p class="hero-sub">Manajemen Data Dunia Usaha dan Dunia Industri</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('dudi.import') }}" class="btn btn--ghost"><svg viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <path d="M7 10l5 5 5-5" />
                    <path d="M12 15V3" />
                </svg> Import
            </a>
            <a href="{{ route('dudi.add') }}" class="btn btn--primary">
                <svg viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg> Add DUDI
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
                        <input id="dudi-search" class="input" type="search" name="search"
                            placeholder="Cari nama, bidang usaha, kontak, atau ID..." value="{{ request('search', '') }}">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Nama DUDI</th>
                            <th>Bidang Usaha</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="dudi-table-body">
                        @include('dudi.partials.dudi_rows', ['dudis' => $dudis])
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info" id="dudi-summary">
                    @include('dudi.partials.dudi_summary', ['dudis' => $dudis])
                </div>
                <div class="pager" id="dudi-pager">
                    @include('dudi.partials.dudi_pager', ['dudis' => $dudis])
                </div>
            </div>
        </section>
    </div>

    <script>
        const dudiIndexUrl = "{{ route('dudi') }}";
        const searchInput = document.getElementById('dudi-search');
        const tableBody = document.getElementById('dudi-table-body');
        const summaryContainer = document.getElementById('dudi-summary');
        const pagerContainer = document.getElementById('dudi-pager');

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
            const url = `${dudiIndexUrl}?${params.toString()}`;

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

                    const summaryUrl = new URL(dudiIndexUrl, window.location.origin);
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
