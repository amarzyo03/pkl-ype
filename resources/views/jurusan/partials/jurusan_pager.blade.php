@php
    $currentPage = $jurusans->currentPage();
    $lastPage = $jurusans->lastPage();
    $pages = range(1, $lastPage);
@endphp

@if ($lastPage > 1)
    <button class="pager-btn" data-page="{{ max(1, $currentPage - 1) }}" aria-label="Previous"
        {{ $currentPage <= 1 ? 'disabled' : '' }}>
        <svg viewBox="0 0 24 24">
            <path d="m15 18-6-6 6-6" />
        </svg>
    </button>

    @foreach ($pages as $page)
        <button class="pager-btn {{ $page == $currentPage ? 'is-active' : '' }}" data-page="{{ $page }}"
            {{ $page == $currentPage ? 'disabled' : '' }}>
            {{ $page }}
        </button>
    @endforeach

    <button class="pager-btn" data-page="{{ min($lastPage, $currentPage + 1) }}" aria-label="Next"
        {{ $currentPage >= $lastPage ? 'disabled' : '' }}>
        <svg viewBox="0 0 24 24">
            <path d="m9 18 6-6-6-6" />
        </svg>
    </button>
@endif
