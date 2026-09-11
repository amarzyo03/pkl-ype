<span>Showing <strong style="color:var(--t-base)">{{ $users->firstItem() }}–{{ $users->lastItem() }}</strong> of
    <strong style="color:var(--t-base)">{{ $users->total() }}</strong>
</span>
<select class="select per-page-select" data-per-page>
    @foreach ([15, 25, 50, 100] as $perPageOption)
        <option value="{{ $perPageOption }}" {{ $users->perPage() == $perPageOption ? 'selected' : '' }}>
            {{ $perPageOption }} per page
        </option>
    @endforeach
</select>
