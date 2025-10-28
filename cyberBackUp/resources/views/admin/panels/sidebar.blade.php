@php
use App\Models\User;
$configData = Helper::applClasses();
$user = Auth::user();
$permissions = $user->permissions();

$permissions = array_map(function ($permession) {
    return $permession->key;
}, $permissions);
// dd($menuData[1]->menu[0]->submenu);
@endphp

    <div class="page-body-wrapper">


        <div class="sidebar-wrapper" data-layout="stroke-svg">
            <div>
                <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}">
                            <img src='{{ asset('storage/'. getSystemSetting('institution_photo')) }}' class="mw-100" alt="Company logo" style="height: 45px; object-fit:contain !important ">
                        </a>
                </div>
                <nav class="sidebar-main">
                    <div id="sidebar-menu">
                        <ul class="sidebar-links" id="simple-bar" data-simplebar="init">
                            <div class="simplebar-wrapper" style="margin: 0px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                    <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                        <div class="simplebar-content-wrapper"
                                            style="height: 100%; overflow: hidden;">
                                            <div class="simplebar-content" style="padding: 0px;">
                                                <li class="back-btn"><a
                                                        href="{{asset('images/logo-symbol-invert.png')}}"></a>
                                                    <div class="mobile-back text-end"><span>Back</span><i
                                                            class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                                                    </div>
                                                </li>
                                                <li class="sidebar-main-title">
                                                    <div></div>
                                                </li>




                                                @if (isset($menuData[1]))
                                                @foreach ($menuData[1]->menu as $menu)
                                                    @php

                                                        $subMenuPermissionStatus = false;
                                                            if (isset($menu->submenu)) {
                                                                // Collect the permission keys from submenu and subsubmenu
 
                                                                $subMenuPermissions = array_map(function ($submenuItem) {
                                                                // Start by adding the main menu item's permission_key
                                                                $permissions = [$submenuItem->permission_key];
                                                                // If the submenu item has a subsubmenu, extract those permissions as well
                                                                if (isset($submenuItem->subsubmenu)) {
                                                                    $subSubMenuPermissions = array_map(function ($subsubmenuItem) {
                                                                        return $subsubmenuItem->permission_key;
                                                                    }, $submenuItem->subsubmenu);
                                                                    // Merge subsubmenu permissions into the main submenu permissions
                                                                    $permissions = array_merge($permissions, $subSubMenuPermissions);
                                                                }

                                                                return $permissions;
                                                            }, $menu->submenu);

                                                            // Flatten the array of permission keys (in case the submenu has multiple subsubmenu items)
                                                            $subMenuPermissions = array_merge(...$subMenuPermissions);

                                                            // Logic for KPI Assessment (As that is not permission put depending on user position [managers] )
                                                            if($menu->name == 'Hierarchy' && isDepartmentManager()) {
                                                                for ($i = 0; $i < count($subMenuPermissions); $i++) {
                                                                    if (in_array($subMenuPermissions[$i], $permissions) || $subMenuPermissions[$i] == '') {
                                                                        $subMenuPermissionStatus = true;
                                                                        break;
                                                                    }
                                                                }
                                                            }

                                                            // Logic for change request (As that is not permission put depending on user must belongs to department )
                                                            if(!$subMenuPermissionStatus && $menu->name == 'Hierarchy'){
                                                                if (!(!(User::whereNotNull('department_id')->where('id', auth()->id())->exists()) || !change_requests_responsible_department_manager_id()))
                                                                    $subMenuPermissionStatus = true;
                                                            }

                                                            if(!$subMenuPermissionStatus){

                                                                for ($i = 0; $i < count($subMenuPermissions); $i++) {

                                                                    if (in_array($subMenuPermissions[$i], $permissions)) {

                                                                        $subMenuPermissionStatus = true;
                                                                        break;
                                                                    }
                                                                }

                                                            }

                                                        } else {

                                                            if((property_exists($menu, 'permission_key') && ($menu->permission_key) && in_array($menu->permission_key, $permissions))
                                                            || !($menu->permission_key)) {
                                                                $subMenuPermissionStatus = true;
                                                            }else {
                                                                $subMenuPermissionStatus = false;
                                                            }
                                                        }

                                                        $custom_classes = '';
                                                        if (isset($menu->classlist)) {
                                                            $custom_classes = $menu->classlist;
                                                        }
                                                        
                                                    @endphp

                                                    @if ($subMenuPermissionStatus && $menu->showStatus)

                                                    <li class="sidebar-list main-sidebar" style="background-color: #44225c;" data-name="{{ $menu->name}}"><a
                                                        class="sidebar-link sidebar-title
                                                      @if (
                                                            (isset($menu->submenu) && is_array($menu->submenu) && collect($menu->submenu)->pluck('activeRoute')->flatten()->contains(Route::currentRouteName())) || (isset($menu->submenu) && is_array($menu->submenu) && collect($menu->submenu)->pluck('subsubmenu')->flatten()->pluck('activeRoute')->flatten()->contains(Route::currentRouteName()))
                                                        )
                                                            active
                                                        @endif"

                                                        href="{{ isset($menu->route) && !empty($menu->route) ? route($menu->route) : 'javascript:void(0)' }}" checked="checked">
                                                        <i class="menu-icon" data-feather="{{ $menu->icon }}"></i>
                                                        <span>{{ __('locale.' . $menu->name) }} </span></a>
                                                        
 
                                                        {{--  @if (isset($menu->submenu))
                                                        @include('admin.panels.horizontalSubmenu', [
                                                            'menu' => $menu->submenu,'name' => $menu->name,'icon' =>  $menu->icon
                                                        ])
                                                    @endif  --}}
                                                    <!-- @dump(collect($menu->submenu)->pluck('subsubmenu')->flatten()->pluck('route')) -->
                                                    <!-- {{ Route::currentRouteName()}} -->
                                                    @if (isset($menu->submenu))
                                                    @include('admin.panels.submenu', ['menu' => $menu->submenu,'name' => $menu->name,'icon' =>  $menu->icon])
                                                    @endif




                                                    </li>


                                                    @endif
                                                @endforeach
                                            @endif
                                            <!-- Bottom Logo -->
                                            <hr>
                                            <div class="logo-wrapper" style=""><a href="{{ route('admin.dashboard') }}">
                                                <a href="{{ route('admin.dashboard') }}">
                                                    <img src="{{ asset('images/logo-symbol-invert.png') }}" class="mw-100" alt="Company logo" style="height: 45px; object-fit:contain !important;">
                                                </a>
                                            </div>

                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: auto; height: 893px;"></div>
                            </div>
                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                            </div>
                            <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                <div class="simplebar-scrollbar"
                                    style="height: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div>
                            </div>
                        </ul>
                    </div>
                </nav>
                
            </div>
        </div>

    </div>



