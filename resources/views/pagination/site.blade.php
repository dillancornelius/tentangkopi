@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Halaman">
        @if ($paginator->onFirstPage())
            <span class="pagination__item is-disabled" aria-disabled="true">Sebelumnya</span>
        @else
            <a class="pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev">Sebelumnya</a>
        @endif

        <div class="pagination__pages">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pagination__gap">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination__item is-current" aria-current="page">{{ $page }}</span>
                        @else
                            <a class="pagination__item" href="{{ $url }}" aria-label="Halaman {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a class="pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya</a>
        @else
            <span class="pagination__item is-disabled" aria-disabled="true">Berikutnya</span>
        @endif
    </nav>
@endif
