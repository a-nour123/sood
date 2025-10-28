@if (auth()->user()->hasPermission($createPermissionKey) ||
        auth()->user()->hasPermission($exportPermissionKey))
    <div id="import-export-container" class="text-center" style=" display: inline-block;">
        <!-- Export form -->
        <form target="_blank" class="d-none" id="export-form" method="post" action="{{ route($exportRouteKey) }}">
            @csrf
            <input type="hidden" name="type" value="excel">
        </form>

        {{-- Export --}}
        @if (auth()->user()->hasPermission($exportPermissionKey))
            <div class="btn-group dropdown dropdown-icon-wrapper ">
                <button type="button" class="btn btn-primary submit-export"
                    data-type="excel"><i class="fa-solid fa-file-export"></i></button>
                {{--  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-file-excel"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end export-types">
                    <span class="dropdown-item" data-type="excel">
                        <span class="px-1">{{ __('locale.Excel') }}</span>
                        <i class="fa-regular fa-file-excel"></i>
                    </span>

                </div>  --}}
            </div>
        @endif

        {{-- Import --}}
        @if (is_array($importRouteKey) && !empty($importRouteKey))


            @if (auth()->user()->hasPermission($createPermissionKey) &&
                    $createOtherCondition &&
                    $importRouteKey != 'will-added-TODO')
                <div class="btn-group dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-file-import"></i>
                    </button>
                    <div class="dropdown-menu" style="min-width:20rem">
                        @foreach($importRouteKey as $button)
                        <a href="{{ route($button['route']) }}" class="dropdown-item">{{ $button['name'] }}</a>
                    @endforeach
                    </div>




                </div>
            @endif
        @else

            @if (auth()->user()->hasPermission($createPermissionKey) && $importRouteKey != 'will-added-TODO')
                <a href="{{ route($importRouteKey) }}" class="dt-button btn btn-primary " target="_self">
                    <i class="fa-solid fa-file-import"></i>
                </a>
            @endif
    </div>
@endif
@endif
