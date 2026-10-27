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

<body>
    <main class="auth-main">
        <div class="auth-card">
            <h2 style="text-align: center;">SMK YPE Kroya</h2>
            <p class="sub" style="text-align: center;">Sistem PKL | Masuk untuk mengakses dashboard</p>
            <form class="auth-form" action="{{ route('auth.login') }}" method="POST">
                @csrf
                <div class="field">
                    <label class="field-label" for="username">Username</label>
                    <div class="input-icon">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="m3 7 9 6 9-6" />
                            </svg>
                        </span>
                        <input type="text" class="input" id="username" name="username" placeholder="Username"
                            required>
                    </div>
                </div>

                <div class="field">
                    <div class="field-row">
                        <label class="field-label" for="password">Password</label>
                        <a href="#">Forgot?</a>
                    </div>
                    <div class="input-icon">
                        <span class="ico">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <input class="input" type="password" id="password" name="password" placeholder="••••••••"
                            required>
                    </div>
                </div>

                <button class="btn btn--primary auth-submit" type="submit">Sign in
                    <svg viewBox="0 0 24 24">
                        <path d="M5 12h14M13 5l7 7-7 7" />
                    </svg>
                </button>
            </form>

            <div class="auth-divider">Tahun Ajaran 2026/2027</div>
        </div>

        <div class="auth-main-bottom">&copy; 2026. TKJ. SMK YPE Kroya. All rights reserved.</div>
    </main>
</body>

</html>
