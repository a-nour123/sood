<ul class="sidebar-submenu custom-scrollbar" style="display: none;">
    @if(isset($menu))
        @foreach($menu as $submenu)
            @php
                // Check if user has permission for the submenu
                $hasSubmenuPermission = (property_exists($submenu, 'permission_key') && in_array($submenu->permission_key, $permissions));
                // Check if the submenu has subsubmenus and the user has permission for them
                $hasParentPermission = (isset($submenu->subsubmenu) && is_array($submenu->subsubmenu)) ? collect($submenu->subsubmenu)->pluck('permission_key')->contains(function($key) use ($permissions) {
                    return in_array($key, $permissions);
                }) : false;

                // Check if user has permission for the parent menu 
                $hasMainPermission = isset($submenu->permission_key) && in_array($submenu->permission_key, $permissions);
                // Set default active menu state
                $activemenu = "";

                // Check if the current route is active
                if ((isset($submenu->activeRoute) && is_array($submenu->activeRoute) && in_array(Route::currentRouteName(), $submenu->activeRoute)) || 
                    (isset($submenu->subsubmenu) && collect($submenu->subsubmenu)->pluck('activeRoute')->flatten()->contains(Route::currentRouteName()))) {
                    $activemenu = 'active';
                }

                // Initialize $subsubmenu variable to null (safe default)
                $subsubmenu = null;

                // If submenu has subsubmenu, process it
                if (isset($submenu->subsubmenu) && is_array($submenu->subsubmenu)) {
                    $subsubmenu = array_map(function($item) {
                        // If a route exists, convert the route name to a URL
                        if (isset($item->route)) {
                            $item->url = route($item->route);
                        }
                        $item->name = trans('locale.' . $item->name); // Translate the name
                        return $item;
                    }, $submenu->subsubmenu);
                }

                // Find the first accessible route in subsubmenu (fallback route)
                $firstAccessibleRoute = null;
                if (isset($submenu->subsubmenu)) {
                    foreach ($submenu->subsubmenu as $subsubmenuItem) {
                        if (in_array($subsubmenuItem->permission_key, $permissions)) {
                            $firstAccessibleRoute = route($subsubmenuItem->route);
                            break;
                        }
                    }
                }
            @endphp

            <!-- Only render the menu item if the user has permission for it -->
            @if($hasSubmenuPermission || $hasParentPermission || $hasMainPermission)
                  <li class="main-submenu open-sub-menu-item" data-subsubmenu="{{ json_encode($subsubmenu) }}" data-activemenu="{{$activemenu}}" data-firstaccessible="{{$firstAccessibleRoute}}">
                    <a class="text-start sidebar-menu {{$activemenu}}"
                       href="{{ $firstAccessibleRoute ?? (isset($submenu->route) && !empty($submenu->route) && in_array($submenu->permission_key, $permissions) ? route($submenu->route) : 'javascript:void(0)') }}">
                        <i data-feather="{{ $submenu->icon }}"></i> {{ __('locale.' . $submenu->name) }}
                    </a>
                </li>
            @endif
        @endforeach
    @endif
</ul>
