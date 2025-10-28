@if ($paginator->hasPages())
    <nav>
        <ul class="pagination custom">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true">
                    <span class="btn btn-primary disabled" style="width: 30px;height: 25px;text-align: center;padding: 5px">&#8249;</span>
                </li>
            @else
                <li>
                    <a class="btn btn-primary " style="width: 30px;height: 25px;text-align: center;padding: 5px" onclick="event.preventDefault()" data-url="{{ $paginator->previousPageUrl() }}" href="javascript:void(0)" rel="prev"> &#8249; </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="btn btn-primary  " style="width: 30px;height: 25px;text-align: center;padding: 5px;" onclick="event.preventDefault()" data-url="{{ $paginator->nextPageUrl() }}" href="javascript:void(0)" rel="next"> &#8250; </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true">
                    <span class="btn btn-primary disabled " style="width: 30px;height: 25px;text-align: center;padding: 5px;">&#8250; </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
