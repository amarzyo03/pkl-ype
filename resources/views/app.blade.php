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

<body data-active="dashboard" data-crumbs="Workspace | Dashboard">
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
</body>

</html>
