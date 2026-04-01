<div class="pagination clearfix style2">
    <div class="nav-link">
        @if ($paginator->onFirstPage())
            <span class="page-numbers disabled"><i class="icon fa fa-angle-left" aria-hidden="true"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-numbers"><i class="icon fa fa-angle-left" aria-hidden="true"></i></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-numbers disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-numbers current">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-numbers">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-numbers"><i class="icon fa fa-angle-right" aria-hidden="true"></i></a>
        @else
            <span class="page-numbers disabled"><i class="icon fa fa-angle-right" aria-hidden="true"></i></span>
        @endif
    </div>
</div>