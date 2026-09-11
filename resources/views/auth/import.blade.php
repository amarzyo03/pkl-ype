@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · User · Import</span>
            <h1 class="hero-title">Import <span class="accent">Users</span></h1>
            <p class="hero-sub">Upload a CSV file to import multiple users into the system.</p>
        </div>
        <div class="hero-actions">
            <button class="btn btn--ghost">Cancel</button>
            <button class="btn btn--primary">Save Changes</button>
        </div>
    </section>

    <section class="card" style="min-height:360px;align-items:center;justify-content:center">
        <div style="text-align:center;color:var(--t-light);padding:60px 20px">
            <div
                style="width:56px;height:56px;margin:0 auto 18px;border-radius:14px;background:var(--bg-muted);color:var(--t-muted);display:grid;place-items:center">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor"
                    stroke-width="1.6">
                    <path d="M12 5v14M5 12h14" />
                </svg>
            </div>
            <div
                style="font-family:'Inter Tight',sans-serif;font-weight:700;font-size:18px;color:var(--t-base);letter-spacing:-.018em;margin-bottom:6px">
                Import Users</div>
            <div style="font-size:13px;max-width:36ch;margin:0 auto">import excel file, (.xlxs)</div>
        </div>
    </section>
@endsection
