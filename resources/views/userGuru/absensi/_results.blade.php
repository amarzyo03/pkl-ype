<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:32px">#</th>
                <th>Tanggal Absensi</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>DUDI</th>
                <th>Foto</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absensi as $row)
                <tr class="data-row">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $row->siswa?->nama ?? 'Siswa tidak tersedia' }}</td>
                    <td>{{ $row->siswa?->kelas?->nama ?? '-' }}</td>
                    <td>{{ $row->siswa?->pendaftaran?->dudi?->nama ?? '-' }}</td>
                    <td>
                        @if ($row->foto)
                            <a href="{{ asset('assets/static/absensi/' . $row->foto) }}" target="_blank"
                                rel="noopener">
                                Lihat foto
                            </a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @php
                            $statusClass = match ($row->status) {
                                'hadir' => 'success',
                                'sakit', 'izin' => 'warning',
                                'alpa' => 'danger',
                                default => 'info',
                            };
                        @endphp
                        <span class="badge dot {{ $statusClass }}">{{ ucfirst($row->status) }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        @if ($tanggal)
                            Tidak ada data absensi pada
                            {{ \Illuminate\Support\Carbon::parse($tanggal)->format('d/m/Y') }}.
                        @else
                            Belum ada data absensi.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="data-foot">
    <div class="data-foot-info">
        @if ($absensi->isNotEmpty())
            Menampilkan {{ $absensi->count() }} absensi
            @if ($tanggal)
                pada {{ \Illuminate\Support\Carbon::parse($tanggal)->format('d/m/Y') }}
            @else
                dari semua tanggal
            @endif
        @else
            @if ($tanggal)
                Tidak ada absensi pada tanggal ini
            @else
                Tidak ada data absensi
            @endif
        @endif
    </div>
</div>
