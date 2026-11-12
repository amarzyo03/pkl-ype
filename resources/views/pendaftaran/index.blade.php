@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Master · Pendaftaran</span>
            <h1 class="hero-title">Data <span class="accent">Pendaftaran</span></h1>
            <p class="hero-sub">Kelola pendaftaran siswa ke tempat PKL dan tinjau statusnya.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('pendaftaran.add') }}" class="btn btn--primary">Tambah Pendaftaran</a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="data-toolbar">
                <form action="{{ route('pendaftaran') }}" method="GET" class="data-toolbar-left"
                    id="pendaftaran-search-form">
                    <div class="input-icon">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input id="pendaftaran-search" class="input" type="search" name="search"
                            placeholder="Cari nama siswa, NIS, atau DUDI..." value="{{ $search }}">
                    </div>
                    <button type="submit" class="btn btn--ghost">Cari</button>
                </form>

                <form action="{{ route('pendaftaran.status.bulk') }}" method="POST" class="data-toolbar-right"
                    id="bulk-registration-status">
                    @csrf
                    @method('PATCH')
                    <select id="bulk-status" class="select" name="status" required>
                        <option value="">Pilih status</option>
                        <option value="pending" @selected(old('status') === 'pending')>Pending</option>
                        <option value="disetujui" @selected(old('status') === 'disetujui')>Disetujui</option>
                        <option value="ditolak" @selected(old('status') === 'ditolak')>Ditolak</option>
                    </select>
                    <button type="submit" class="btn btn--primary">Konfirmasi yang dicentang</button>
                    @if ($errors->any())
                        <div role="alert">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>

            <div class="table-responsive" tabindex="0" role="region" aria-label="Tabel data pendaftaran">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>
                                <input type="checkbox" id="select-all-pendaftaran" aria-label="Centang semua pendaftaran">
                            </th>
                            <th>Siswa</th>
                            <th>DUDI</th>
                            <th>Status</th>
                            <th>Konfirmasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pendaftaran-table-body">
                        @include('pendaftaran.partials.pendaftaran_rows', ['pendaftarans' => $pendaftarans])
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info" id="pendaftaran-summary">
                    @include('pendaftaran.partials.pendaftaran_summary', ['pendaftarans' => $pendaftarans])
                </div>
                <div class="pager" id="pendaftaran-pager">
                    @include('pendaftaran.partials.pendaftaran_pager', ['pendaftarans' => $pendaftarans])
                </div>
            </div>
        </section>
    </div>

    <script>
        const pendaftaranIndexUrl = "{{ route('pendaftaran') }}";
        const searchForm = document.getElementById('pendaftaran-search-form');
        const searchInput = document.getElementById('pendaftaran-search');
        const tableBody = document.getElementById('pendaftaran-table-body');
        const summaryContainer = document.getElementById('pendaftaran-summary');
        const pagerContainer = document.getElementById('pendaftaran-pager');

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
            const url = `${pendaftaranIndexUrl}?${params.toString()}`;

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal memuat data pendaftaran.');
                    }

                    return response.json();
                })
                .then(data => {
                    tableBody.innerHTML = data.rows;
                    summaryContainer.innerHTML = data.summary;
                    pagerContainer.innerHTML = data.pager;
                    document.getElementById('select-all-pendaftaran').checked = false;

                    const summaryUrl = new URL(pendaftaranIndexUrl, window.location.origin);
                    summaryUrl.search = params.toString().replace(/&ajax=1/g, '');
                    history.replaceState({}, '', summaryUrl.toString().replace(window.location.origin, ''));
                })
                .catch(error => {
                    console.error(error);
                    window.showToast('Gagal memuat data pendaftaran. Silakan coba lagi.', 'error');
                });
        }

        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();
            updateList(1);
        });

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

        document.getElementById('select-all-pendaftaran').addEventListener('change', function() {
            document.querySelectorAll('tbody input[name="pendaftaran_ids[]"]').forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });
    </script>
@endsection
