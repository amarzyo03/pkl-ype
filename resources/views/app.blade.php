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
        const tugasSidebarObserver = new MutationObserver(() => {
            const workspaceSection = [...document.querySelectorAll('.nav-section')]
                .find((section) => section.querySelector('.nav-label')?.textContent.trim() === 'Workspace');

            if (!workspaceSection) {
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

            tugasSidebarObserver.disconnect();
        });

        tugasSidebarObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>
</body>

</html>
