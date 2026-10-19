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
    <div class="auth-shell">
        <aside class="auth-aside">
            <div class="auth-brand">
                <div class="logo">
                    <svg viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#fff"
                            d="M14.747 9.125c.527-1.426 1.736-2.573 3.317-2.573c1.643 0 2.792 1.085 3.318 2.573l6.077 16.867c.186.496.248.931.248 1.147c0 1.209-.992 2.046-2.139 2.046c-1.303 0-1.954-.682-2.264-1.611l-.931-2.915h-8.62l-.93 2.884c-.31.961-.961 1.642-2.232 1.642c-1.24 0-2.294-.93-2.294-2.17c0-.496.155-.868.217-1.023l6.233-16.867zm.34 11.256h5.891l-2.883-8.992h-.062l-2.946 8.992z" />
                    </svg>
                </div>
                <div class="name">Adminator</div>
            </div>
            <div class="auth-aside-body"><span class="auth-aside-eyebrow">2026 · v3.1 preview</span>
                <h1>The dashboard your team actually wants to open.</h1>
                <p>Faster builds, cleaner tokens, and a design system that scales from a single chart to a 12-screen ops
                    cockpit.</p>
                <div class="auth-quote">"We replaced four bespoke admin tools with one Adminator workspace. The dark
                    mode alone earned its keep."<div class="auth-quote-author">
                        <div class="av">SK</div>
                        <div>Sara Kim · Head of Engineering, Northwind</div>
                    </div>
                </div>
            </div>
            <div class="auth-aside-footer"><span>© 2026</span> <span>BUILT IN RIGA, LV</span></div>
        </aside>

        <main class="auth-main">

            <div class="auth-card">
                <h2>Login Siswa</h2>
                <p class="sub">Silahkan login terlebih dahulu untuk mengakses dashboard</p>
                <form class="auth-form" onsubmit='event.preventDefault(),window.location="index.html"'>
                    <div class="field">
                        <label class="field-label" for="username">Username</label>
                        <div class="input-icon">
                            <span class="ico">
                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <path d="m3 7 9 6 9-6" />
                                </svg>
                            </span>
                            <input id="username" class="input" type="text" placeholder="Username"
                                autocomplete="username" required>
                        </div>
                    </div>
                    <div class="field">
                        <div class="field-row">
                            <label class="field-label" for="password">Password</label>
                        </div>
                        <div class="input-icon">
                            <span class="ico">
                                <svg viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input id="password" class="input" type="password" placeholder="••••••••"
                                autocomplete="current-password" required>
                        </div>
                    </div>
                </form>
                <div class="auth-divider">SMK YPE Kroya</div>

            </div>
            <div class="auth-main-bottom">By signing in you agree to our <a href="#">Terms</a> and <a
                    href="#">Privacy Policy</a>.</div>
        </main>
    </div>
</body>

</html>
