@if ($pendaftarans->total() > 0)
    Menampilkan {{ $pendaftarans->firstItem() }}–{{ $pendaftarans->lastItem() }} dari
    {{ $pendaftarans->total() }} pendaftaran
@else
    Tidak ada pendaftaran
@endif

<select class="select per-page-select" data-per-page aria-label="Jumlah pendaftaran per halaman">
    @foreach ([15, 25, 50, 100] as $perPageOption)
        <option value="{{ $perPageOption }}" {{ $pendaftarans->perPage() == $perPageOption ? 'selected' : '' }}>
            {{ $perPageOption }} per halaman
        </option>
    @endforeach
</select>
