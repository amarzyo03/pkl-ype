@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text"><span class="eyebrow">Master · DUDI · Import</span>
            <h1 class="hero-title">Import <span class="accent">DUDI</span></h1>
            <p class="hero-sub">Upload file Excel untuk menambahkan atau memperbarui data DUDI.</p>
        </div>
        <div class="hero-actions">
            <a href="{{ route('dudi') }}" class="btn btn--ghost">Cancel</a>
            <a href="{{ asset('assets/static/template/dudi-import-template.xlsx') }}" class="btn btn--ghost"
                download>Download Template</a>
            <button type="submit" class="btn btn--primary" form="import-form">Import Data</button>
        </div>
    </section>

    <section class="card" style="min-height:360px;display:flex;align-items:center;justify-content:center">
        <div style="width:min(100%,560px);padding:20px;">
            <form id="import-form" action="{{ route('dudi.import.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom:18px;">
                    <label for="file" style="display:block;margin-bottom:8px;font-weight:600;color:var(--t-base);">Pilih
                        File Excel</label>
                    <input id="file" name="file" type="file" accept=".xlsx,.xls,.csv" class="input"
                        style="padding:14px;" required>
                </div>

                @if ($errors->any())
                    <div
                        style="margin-bottom:16px;padding:12px;border-radius:10px;background:rgba(239,68,68,.08);color:#ef4444;border:1px solid rgba(239,68,68,.2);">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div
                    style="padding:16px;border-radius:12px;background:var(--bg-muted);border:1px solid rgba(148,163,184,.2);color:var(--t-muted);font-size:13px;line-height:1.6;">
                    Kolom pada file Excel:<br>
                    <strong>nama</strong>, <strong>bidang_usaha</strong>, <strong>alamat</strong>, <strong>telepon</strong>,
                    <strong>email</strong><br><br>
                    Baris data tanpa <strong>nama</strong> akan dilewati. Data dengan nama yang sama akan diperbarui.
                </div>
            </form>
        </div>
    </section>
@endsection
