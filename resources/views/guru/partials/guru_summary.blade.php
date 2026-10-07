<span>Showing <strong style="color:var(--t-base)">{{ $gurus->firstItem() ?? 0 }}–{{ $gurus->lastItem() ?? 0 }}</strong>
    of
    <strong style="color:var(--t-base)">{{ $gurus->total() }}</strong>
</span>
<select class="select per-page-select" data-per-page>
    @foreach ([15, 25, 50, 100] as $perPageOption)
        <option value="{{ $perPageOption }}" {{ $gurus->perPage() == $perPageOption ? 'selected' : '' }}>
            {{ $perPageOption }} per page
        </option>
    @endforeach
</select>
