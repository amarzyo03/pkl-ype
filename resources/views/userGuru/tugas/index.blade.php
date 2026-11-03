@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Workspace · Tugas</span>
            <h1 class="hero-title">Data <span class="accent">Tugas</span></h1>
            <p class="hero-sub">{{ $guru->nama }} | Kelola tugas, guru pemberi tugas, tanggal, dan lampirannya.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('tugas.add') }}" class="btn btn--primary">Tambah Tugas</a>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <form action="{{ route('tugas') }}" method="GET" class="data-toolbar">
                <div class="data-toolbar-left">
                    <div class="input-icon" style="flex:1;max-width:420px">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="7" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input class="input" type="search" name="search"
                            placeholder="Cari judul, deskripsi, guru, atau tanggal..." value="{{ $search }}">
                    </div>
                    <input type="hidden" name="perPage" value="{{ $tugas->perPage() }}">
                    <button type="submit" class="btn btn--ghost">Cari</button>
                </div>
            </form>

            <div id="tugas-results" aria-live="polite">
                @include('userGuru.tugas._results', ['tugas' => $tugas])
            </div>

            <p id="tugas-ajax-error" class="text-muted" role="status" hidden></p>
        </section>
    </div>

    <script>
        (() => {
            const form = document.querySelector('.data-toolbar');
            const searchInput = form.querySelector('[name="search"]');
            const perPageInput = form.querySelector('[name="perPage"]');
            const results = document.getElementById('tugas-results');
            const errorMessage = document.getElementById('tugas-ajax-error');
            let debounceTimeout;
            let activeRequest;

            const formUrl = () => {
                const url = new URL(form.action, window.location.href);
                new FormData(form).forEach((value, key) => {
                    if (typeof value === 'string') {
                        url.searchParams.set(key, value);
                    }
                });
                url.searchParams.delete('page');

                return url;
            };

            const loadResults = async (url, historyMethod = null) => {
                activeRequest?.abort();

                const request = new AbortController();
                activeRequest = request;
                results.setAttribute('aria-busy', 'true');
                errorMessage.hidden = true;

                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html',
                        },
                        signal: request.signal,
                    });

                    if (!response.ok) {
                        throw new Error(`Tugas gagal dimuat (${response.status}).`);
                    }

                    results.innerHTML = await response.text();

                    if (historyMethod) {
                        window.history[historyMethod]({}, '', url);
                    }

                    const loadedUrl = new URL(url, window.location.href);
                    searchInput.value = loadedUrl.searchParams.get('search') ?? '';
                    perPageInput.value = loadedUrl.searchParams.get('perPage') ?? '15';
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    console.error('Gagal memuat daftar tugas.', error);
                    errorMessage.textContent = 'Gagal memuat data tugas. Silakan coba lagi.';
                    errorMessage.hidden = false;
                    window.showToast(errorMessage.textContent, 'error');
                } finally {
                    if (activeRequest === request) {
                        activeRequest = null;
                        results.removeAttribute('aria-busy');
                    }
                }
            };

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                loadResults(formUrl(), 'replaceState');
            });

            searchInput.addEventListener('input', () => {
                window.clearTimeout(debounceTimeout);
                debounceTimeout = window.setTimeout(() => {
                    loadResults(formUrl(), 'replaceState');
                }, 300);
            });

            results.addEventListener('change', (event) => {
                if (!event.target.matches('[data-per-page]')) {
                    return;
                }

                perPageInput.value = event.target.value;
                loadResults(formUrl(), 'replaceState');
            });

            results.addEventListener('click', (event) => {
                const link = event.target.closest('.pager a');
                if (!link) {
                    return;
                }

                event.preventDefault();
                loadResults(link.href, 'pushState');
            });

            window.addEventListener('popstate', () => {
                loadResults(window.location.href);
            });
        })();
    </script>
@endsection
