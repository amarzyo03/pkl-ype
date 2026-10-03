<span>Showing <strong style="color:var(--t-base)">{{ $kelas->firstItem() }}–{{ $kelas->lastItem() }}</strong> of
    <strong style="color:var(--t-base)">{{ $kelas->total() }}</strong>
</span>
<select class="select per-page-select" data-per-page>
    @foreach ([15, 25, 50, 100] as $perPageOption)
        <option value="{{ $perPageOption }}" {{ $kelas->perPage() == $perPageOption ? 'selected' : '' }}>
            {{ $perPageOption }} per page
        </option>
    @endforeach
</select>
