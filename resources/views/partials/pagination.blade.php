@if ($paginator->hasPages())
<nav aria-label="Page navigation">
    <ul class="pagination common-pagination">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <li class="page-item">
                <button wire:click="previousPage" class="page-link flx-align gap-2 flex-nowrap">
                    <span class="icon line-height-1 font-20"><i class="las la-arrow-left"></i></span>
                </button>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="page-item @if($page == $paginator->currentPage()) active @endif">
                        <button wire:click="gotoPage({{ $page }})" class="page-link">
                            {{ $page }}
                        </button>
                    </li>
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <button wire:click="nextPage" class="page-link flx-align gap-2 flex-nowrap">
                    Next
                    <span class="icon line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                </button>
            </li>
        @endif
    </ul>
</nav>
@endif
