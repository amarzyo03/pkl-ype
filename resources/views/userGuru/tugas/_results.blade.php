<div class="table-responsive" tabindex="0" role="region" aria-label="Tabel daftar tugas">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:32px">#</th>
                <th>Tanggal</th>
                <th>Judul</th>
                <th>Guru</th>
                <th>Deskripsi</th>
                <th>Lampiran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tugas as $row)
                <tr class="data-row">
                    <td>{{ $tugas->firstItem() + $loop->index }}</td>
                    <td>{{ $row->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $row->judul }}</td>
                    <td>{{ $row->guru?->nama ?? 'Guru tidak tersedia' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($row->deskripsi, 120) }}</td>
                    <td>
                        @if ($row->file)
                            <a href="{{ route('tugas.file', $row->id) }}">{{ $row->file }}</a>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('tugas.status', $row->id) }}" class="btn btn--ghost btn--small">
                            Lihat status
                        </a>
                    </td>
                    <td>
                        <div class="data-cell-actions">
                            <a href="{{ route('tugas.edit', $row->id) }}" class="btn--icon"
                                aria-label="Ubah tugas" title="Ubah">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                                </svg>
                            </a>
                            <form action="{{ route('tugas.delete', $row->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn--icon btn--icon-delete"
                                    aria-label="Hapus tugas" title="Hapus">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4h8v2" />
                                        <path d="M19 6l-1 14H6L5 6" />
                                        <path d="M10 11v6M14 11v6" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data tugas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="data-foot">
    <div class="data-foot-info">
        @if ($tugas->total() > 0)
            Menampilkan {{ $tugas->firstItem() }}–{{ $tugas->lastItem() }} dari {{ $tugas->total() }} tugas
        @else
            Tidak ada tugas
        @endif
        <select class="select" data-per-page aria-label="Jumlah tugas per halaman">
            @foreach ([15, 25, 50, 100] as $perPageOption)
                <option value="{{ $perPageOption }}" {{ $tugas->perPage() === $perPageOption ? 'selected' : '' }}>
                    {{ $perPageOption }} per halaman
                </option>
            @endforeach
        </select>
    </div>
    <div class="pager">
        @if ($tugas->onFirstPage())
            <span class="btn--icon disabled" aria-label="Halaman sebelumnya">‹</span>
        @else
            <a href="{{ $tugas->previousPageUrl() }}" class="btn--icon" aria-label="Halaman sebelumnya">‹</a>
        @endif
        @foreach ($tugas->getUrlRange(max(1, $tugas->currentPage() - 2), min($tugas->lastPage(), $tugas->currentPage() + 2)) as $page => $url)
            <a href="{{ $url }}" class="btn--icon {{ $page === $tugas->currentPage() ? 'active' : '' }}"
                aria-label="Halaman {{ $page }}">{{ $page }}</a>
        @endforeach
        @if ($tugas->hasMorePages())
            <a href="{{ $tugas->nextPageUrl() }}" class="btn--icon" aria-label="Halaman berikutnya">›</a>
        @else
            <span class="btn--icon disabled" aria-label="Halaman berikutnya">›</span>
        @endif
    </div>
</div>
