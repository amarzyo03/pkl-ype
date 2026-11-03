@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Guru · Absensi</span>
            <h1 class="hero-title">Daftar <span class="accent">Absensi</span></h1>
            <p class="hero-sub">Pantau absensi siswa dari DUDI bimbingan Anda.</p>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <form id="guru-absensi-filter" action="{{ route('userGuru.absensi') }}" method="GET" class="data-toolbar">
                <div class="data-toolbar-left">
                    <label class="field-label" for="absensi-tanggal">Tanggal absensi</label>
                    <input class="input" type="date" id="absensi-tanggal" name="tanggal" value="{{ $tanggal }}"
                        >
                    <button class="btn btn--ghost" type="submit">Tampilkan</button>
                </div>
            </form>

            <div id="guru-absensi-results" aria-live="polite">
                @include('userGuru.absensi._results', ['absensi' => $absensi, 'tanggal' => $tanggal])
            </div>

            <p id="guru-absensi-error" class="text-muted" role="status" hidden></p>
        </section>
    </div>

    <script>
        (() => {
            const form = document.getElementById('guru-absensi-filter');
            const dateInput = document.getElementById('absensi-tanggal');
            const results = document.getElementById('guru-absensi-results');
            const errorMessage = document.getElementById('guru-absensi-error');
            let activeRequest;

            const loadAttendance = async (updateHistory = true) => {
                activeRequest?.abort();
                const request = new AbortController();
                activeRequest = request;
                results.setAttribute('aria-busy', 'true');
                errorMessage.hidden = true;

                const url = new URL(form.action, window.location.href);
                if (dateInput.value) {
                    url.searchParams.set('tanggal', dateInput.value);
                } else {
                    url.searchParams.delete('tanggal');
                }

                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html',
                        },
                        signal: request.signal,
                    });

                    if (!response.ok) {
                        throw new Error(`Absensi gagal dimuat (${response.status}).`);
                    }

                    results.innerHTML = await response.text();

                    if (updateHistory) {
                        window.history.replaceState({}, '', url);
                    }
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    console.error('Gagal memuat daftar absensi.', error);
                    errorMessage.textContent = 'Gagal memuat data absensi. Silakan coba lagi.';
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
                loadAttendance();
            });

            dateInput.addEventListener('change', () => loadAttendance());

            window.addEventListener('popstate', () => {
                const url = new URL(window.location.href);
                dateInput.value = url.searchParams.get('tanggal') ?? '';
                loadAttendance(false);
            });
        })();
    </script>
@endsection
