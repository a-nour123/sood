@php
use App\Models\User;
@endphp
{{-- <style>
    ::-webkit-scrollbar {
      width: 20px;
    }

    ::-webkit-scrollbar-track {
      box-shadow: inset 0 0 5px grey;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: #000;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #b30000;
    }
    </style> --}}
<ul class="dropdown-menu" data-bs-popper="none" style="max-height: 60vh; overflow-y: auto;">
    @if(isset($menu))
    @foreach($menu as $submenu)

    {{-- Add change request logic --}}
    @if (property_exists($submenu, 'route') && $submenu->route == "admin.change_request.index")

    @if (!(User::whereNotNull('department_id')->where('id', auth()->id())->exists()) || !change_requests_responsible_department_manager_id())
    @continue
    @endif
    @endif

    @if((!(property_exists($submenu, 'permission_key') && $submenu->permission_key == '') && !(property_exists($submenu, 'permission_key') && in_array($submenu->permission_key, $permissions))) || !$submenu->showStatus || ($submenu->name == 'SetKPIAssessment' && !isDepartmentManager()))
    @continue
    @endif
    @php
    $custom_classes = "";
    if(isset($submenu->classlist)) {
    $custom_classes = $submenu->classlist;
    }
    @endphp

    <li  class="{{ $custom_classes }} {{ (isset($submenu->submenu)) ? 'dropdown dropdown-submenu' : '' }}  {{ property_exists($submenu, 'route') && $submenu->route === Route::currentRouteName() ? 'active' : '' }}" @if(isset($submenu->submenu)){{'data-menu=dropdown-submenu'}}@endif>
        <a href="{{(isset($submenu->route) && !empty($submenu->route))? route($submenu->route):'javascript:void(0)'}}" class="dropdown-item {{ (isset($submenu->submenu)) ? 'dropdown-toggle' : ''}} d-flex align-items-center" {{ (isset($submenu->submenu)) ? 'data-bs-toggle=dropdown' : '' }} target="{{isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'}}">
            @if (isset($submenu->icon))
            <i data-feather="{{ $submenu->icon }}"></i>
            @endif
            <span>{{ __('locale.'.$submenu->name) }}</span>
        </a>
        @if (isset($submenu->submenu))
        @include('admin.panels.horizontalSubmenu', ['menu' => $submenu->submenu])
        @endif
    </li>
    @endforeach
    @endif
</ul>
