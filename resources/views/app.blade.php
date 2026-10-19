<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Dashboard · 2026 Redesign Preview</title>
    <script>
        ! function() {
            try {
                var t = localStorage.getItem("dash26-theme"),
                    e = window.matchMedia("(prefers-color-scheme: dark)").matches;
                document.documentElement.setAttribute("data-theme", t || (e ? "dark" : "light"))
            } catch (t) {
                document.documentElement.setAttribute("data-theme", "light")
            }
        }()
    </script>
    <script defer="defer" src="/assets/runtime.js"></script>
    <script defer="defer" src="/assets/vendor-fullcalendar.js"></script>
    <script defer="defer" src="/assets/vendor-chartjs.js"></script>
    <script defer="defer" src="/assets/vendors.js"></script>
    <script defer="defer" src="/assets/2026.js"></script>
    <link href="/assets/style.css" rel="stylesheet">
</head>

<body data-active="{{ request()->segment(1) ?: 'dashboard' }}" data-crumbs="Workspace | Dashboard">
    <div class="shell">
        <div data-shell-sidebar></div>
        <div class="main">
            <div data-shell-topbar></div>
            <main class="content">
                @yield('content')
            </main>
            <div data-shell-footer></div>
        </div>
    </div>
    <script>
        const sidebarObserver = new MutationObserver(() => {
            const workspaceSection = [...document.querySelectorAll('.nav-section')]
                .find((section) => section.querySelector('.nav-label')?.textContent.trim() === 'Workspace');
            const masterSection = [...document.querySelectorAll('.nav-section')]
                .find((section) => section.querySelector('.nav-label')?.textContent.trim() === 'Master');

            if (!workspaceSection || !masterSection) {
                return;
            }

            let tugasLink = workspaceSection.querySelector('[data-tugas-sidebar-link]');
            if (!tugasLink) {
                tugasLink = document.createElement('a');
                tugasLink.href = "{{ route('tugas') }}";
                tugasLink.className = `nav-link${document.body.dataset.active === 'tugas' ? ' is-active' : ''}`;
                tugasLink.dataset.tugasSidebarLink = '';
                tugasLink.innerHTML =
                    '<svg viewBox="0 0 24 24"><path d="M5 3h14v18H5z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg><span>Tugas</span>';

                const jurnalLink = workspaceSection.querySelector('a[href="/jurnal"]');
                jurnalLink ? jurnalLink.insertAdjacentElement('afterend', tugasLink) : workspaceSection.append(
                    tugasLink);
            }

            if (!workspaceSection.querySelector('[data-pendaftaran-sidebar-link]')) {
                const pendaftaranLink = document.createElement('a');
                pendaftaranLink.href = "{{ route('pendaftaran') }}";
                pendaftaranLink.className =
                    `nav-link${document.body.dataset.active === 'pendaftaran' ? ' is-active' : ''}`;
                pendaftaranLink.dataset.pendaftaranSidebarLink = '';
                pendaftaranLink.innerHTML =
                    '<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M20 8v6M17 11h6"/></svg><span>Pendaftaran</span>';

                tugasLink.insertAdjacentElement('afterend', pendaftaranLink);
            }

            if (!masterSection.querySelector('[data-dudi-sidebar-link]')) {
                const dudiLink = document.createElement('a');
                dudiLink.href = "{{ route('dudi') }}";
                dudiLink.className = `nav-link${document.body.dataset.active === 'dudi' ? ' is-active' : ''}`;
                dudiLink.dataset.dudiSidebarLink = '';
                dudiLink.innerHTML =
                    '<svg viewBox="0 0 24 24"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M9 9h.01M15 9h.01"/></svg><span>DUDI</span>';

                masterSection.append(dudiLink);
            }

            const masterLinks = ['/dudi', '/siswa', '/guru', '/kelas', '/jurusan', '/user']
                .map((href) => masterSection.querySelector(`a[href="${href}"]`))
                .filter(Boolean);

            masterLinks.forEach((link) => masterSection.append(link));

            sidebarObserver.disconnect();
        });

        sidebarObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>
</body>

</html>
