@if ($paginator->hasPages() || $paginator->total() > 0)
    <nav class="catalog-pagination-nav" role="navigation" aria-label="Pagination">
        <div class="catalog-pagination-panel">
            @if ($paginator->total() > 0)
                <p class="catalog-pagination-summary">
                    Showing
                    <span class="catalog-pagination-highlight">{{ $paginator->firstItem() ?? 0 }}</span>
                    to
                    <span class="catalog-pagination-highlight">{{ $paginator->lastItem() ?? 0 }}</span>
                    of
                    <span class="catalog-pagination-highlight">{{ $paginator->total() }}</span>
                    results
                </p>
            @endif

            @if ($paginator->hasPages())
                <div class="catalog-pagination-pills">
                    <ul class="pagination catalog-pagination-list mb-0">
                        @if ($paginator->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                <span class="page-link" aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa-solid fa-chevron-left"></i></a>
                            </li>
                        @endif

                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <li class="page-item disabled" aria-disabled="true"><span class="page-link catalog-pagination-ellipsis">{{ $element }}</span></li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($paginator->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fa-solid fa-chevron-right"></i></a>
                            </li>
                        @else
                            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                <span class="page-link" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </nav>
@endif
