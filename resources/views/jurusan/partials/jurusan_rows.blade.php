@forelse ($jurusans as $row)
    <tr class="data-row">
        <td>{{ $jurusans->firstItem() + $loop->index }}</td>
        <td>{{ $row->kode }}</td>
        <td>{{ $row->nama }}</td>
        <td>
            <div class="data-cell-actions">
                <a href="{{ route('jurusan.edit', $row->id) }}" class="btn--icon" aria-label="Edit" title="Edit">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4z" />
                    </svg>
                </a>
                <form action="{{ route('jurusan.delete', $row->id) }}" method="post" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn--icon btn--icon-delete" aria-label="Delete" title="Delete">
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
        <td colspan="4" class="text-center text-muted">No jurusan data Found.</td>
    </tr>
@endforelse
