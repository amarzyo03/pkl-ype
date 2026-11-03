@extends('app')
@section('content')
    <section class="hero">
        <div class="hero-text">
            <span class="eyebrow">Guru · DUDI</span>
            <h1 class="hero-title">Daftar <span class="accent">DUDI</span></h1>
            <p class="hero-sub">Daftar mitra dunia usaha dan dunia industri yang menjadi tanggung jawab Anda.</p>
        </div>
    </section>

    <div class="grid">
        <section class="col-12 card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:32px">#</th>
                            <th>Nama DUDI</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>PIC</th>
                            <th>Jurusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dudi as $row)
                            <tr class="data-row">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ strtoupper($row->nama) }}</td>
                                <td>{{ $row->alamat }}</td>
                                <td>{{ $row->telp }}</td>
                                <td>{{ ucwords($row->pic ?? '-') }}</td>
                                <td>{{ ucwords($row->jurusan?->nama ?? '-') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data DUDI untuk guru ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="data-foot">
                <div class="data-foot-info">
                    @if ($dudi->isNotEmpty())
                        Menampilkan {{ $dudi->count() }} DUDI
                    @else
                        Tidak ada DUDI
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
