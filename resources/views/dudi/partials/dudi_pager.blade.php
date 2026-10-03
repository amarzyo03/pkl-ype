@if ($dudis->hasPages())
    @if ($dudis->onFirstPage())
        <span class="btn--icon disabled" aria-label="Previous page" title="Previous page">‹</span>
    @else
        <a href="{{ $dudis->previousPageUrl() }}" class="btn--icon" data-page="{{ $dudis->currentPage() - 1 }}"
            aria-label="Previous page" title="Previous page">‹</a>
    @endif

    @foreach ($dudis->getUrlRange(max(1, $dudis->currentPage() - 2), min($dudis->lastPage(), $dudis->currentPage() + 2)) as $page => $url)
        <a href="{{ $url }}" class="btn--icon {{ $page === $dudis->currentPage() ? 'active' : '' }}"
            data-page="{{ $page }}" aria-label="Page {{ $page }}">{{ $page }}</a>
    @endforeach

    @if ($dudis->hasMorePages())
        <a href="{{ $dudis->nextPageUrl() }}" class="btn--icon" data-page="{{ $dudis->currentPage() + 1 }}"
            aria-label="Next page" title="Next page">›</a>
    @else
        <span class="btn--icon disabled" aria-label="Next page" title="Next page">›</span>
    @endif
@endif
