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
{{-- Horizontal Menu --}}
<div class="horizontal-menu-wrapper new_header">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal
  {{ $configData['horizontalMenuClass'] }}
  {{ $configData['theme'] === 'dark' ? 'navbar-dark' : 'navbar-light' }}
  navbar-shadow menu-border
  {{ $configData['layoutWidth'] === 'boxed' && $configData['horizontalMenuType'] === 'navbar-floating'? 'container-xxl': '' }}"
        role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto" style="max-width: 80%">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <span class="brand-logo">
                            <img src="{{ asset(getSystemSetting('APP_LOGO')) }}" alt="Company logo">
                        </span>
                        <h2 class="brand-text text-truncate"
                            title="{{ session()->get('locale') == 'ar' ? getSystemSetting('APP_OWNER_AR', 'اسم الشركة') : getSystemSetting('APP_OWNER_EN', 'Company Name') }}">
                            {{ session()->get('locale') == 'ar' ? getSystemSetting('APP_OWNER_AR', 'اسم الشركة') : getSystemSetting('APP_OWNER_EN', 'Company Name') }}
                        </h2>
                    </a>
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse">
                        <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <!-- Horizontal menu content-->
        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                {{-- Foreach menu item starts --}}
                @if (isset($menuData[1]))
                    @foreach ($menuData[1]->menu as $menu)
                        @php
                            $subMenuPermissionStatus = false;
                            if (isset($menu->submenu)) {
                                $subMenuPermissions = array_map(function ($permession) {
                                    return $permession->permission_key;
                                }, $menu->submenu);

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

                            <li class="nav-item @if (isset($menu->submenu)) {{ 'dropdown' }} @endif {{ $custom_classes }} {{ property_exists($menu, 'route') && Route::currentRouteName() === $menu->route ? 'active' : '' }}"
                                @if (isset($menu->submenu)) {{ 'data-menu=dropdown' }} @endif>
                                <a href="{{ isset($menu->route) && !empty($menu->route) ? route($menu->route) : 'javascript:void(0)' }}"
                                    class="nav-link d-flex align-items-center @if (isset($menu->submenu)) {{ 'dropdown-toggle' }} @endif"
                                    target="{{ isset($menu->newTab) ? '_blank' : '_self' }}"
                                    @if (isset($menu->submenu)) {{ 'data-bs-toggle=dropdown' }} @endif>
                                    <i data-feather="{{ $menu->icon }}"></i>
                                    <span>{{ __('locale.' . $menu->name) }}</span>
                                </a>
                                @if (isset($menu->submenu))
                                    @include('admin.panels.horizontalSubmenu', [
                                        'menu' => $menu->submenu,
                                    ])
                                @endif
                            </li>
                        @endif
                    @endforeach
                @endif
                {{-- Foreach menu item ends --}}
            </ul>
        </div>
    </div>
</div>
