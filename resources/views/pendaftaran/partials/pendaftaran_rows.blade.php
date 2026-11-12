@forelse ($pendaftarans as $row)
    <tr class="data-row">
        <td>{{ $pendaftarans->firstItem() + $loop->index }}</td>
        <td>
            <input type="checkbox" name="pendaftaran_ids[]" value="{{ $row->id }}" form="bulk-registration-status"
                aria-label="Pilih pendaftaran {{ $row->siswa?->nama ?? $row->id }}">
        </td>
        <td>{{ ucwords($row->siswa?->nama ?? 'Siswa tidak tersedia') }}</td>
        <td>{{ $row->dudi?->nama ?? 'DUDI tidak tersedia' }}</td>
        <td>
            @php
                $statusClass = match ($row->status) {
                    'pending' => 'warning',
                    'disetujui' => 'success',
                    'ditolak' => 'danger',
                    default => 'info',
                };
            @endphp
            <span class="badge dot {{ $statusClass }}">{{ ucfirst($row->status) }}</span>
        </td>
        <td>
            @if ($row->status === 'pending')
                <form action="{{ route('pendaftaran.status', $row->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="disetujui">
                    <button type="submit" class="btn btn--success btn--small" title="Setujui pendaftaran">Setujui</button>
                </form>
                <form action="{{ route('pendaftaran.status', $row->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="ditolak">
                    <button type="submit" class="btn btn--danger btn--small" title="Tolak pendaftaran">Tolak</button>
                </form>
            @else
                <form action="{{ route('pendaftaran.status', $row->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="btn btn--ghost btn--small"
                        title="Batalkan keputusan dan kembalikan status ke pending">
                        Batalkan keputusan
                    </button>
                </form>
            @endif
        </td>
        <td>
            <div class="data-cell-actions">
                <a href="{{ route('pendaftaran.edit', $row->id) }}" class="btn--icon" aria-label="Ubah pendaftaran"
                    title="Ubah">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                    </svg>
                </a>
                <form action="{{ route('pendaftaran.delete', $row->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn--icon btn--icon-delete" aria-label="Hapus pendaftaran" title="Hapus">
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
        <td colspan="7" class="text-center text-muted">Belum ada data pendaftaran.</td>
    </tr>
@endforelse
