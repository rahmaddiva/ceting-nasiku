@if ($paginator->hasPages())
<nav class="ceting-pagination" role="navigation" aria-label="Navigasi halaman">
    <p class="ceting-pagination-info">
        Menampilkan
        <strong>{{ $paginator->firstItem() }}</strong>–<strong>{{ $paginator->lastItem() }}</strong>
        dari <strong>{{ $paginator->total() }}</strong> resep
    </p>

    <ul class="ceting-pagination-list">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li><span class="ceting-page-btn is-disabled" aria-disabled="true">&laquo;</span></li>
        @else
            <li><a class="ceting-page-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya">&laquo;</a></li>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li><span class="ceting-page-btn is-disabled">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="ceting-page-btn is-active" aria-current="page">{{ $page }}</span></li>
                    @else
                        <li><a class="ceting-page-btn" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li><a class="ceting-page-btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya">&raquo;</a></li>
        @else
            <li><span class="ceting-page-btn is-disabled" aria-disabled="true">&raquo;</span></li>
        @endif
    </ul>
</nav>
@endif
