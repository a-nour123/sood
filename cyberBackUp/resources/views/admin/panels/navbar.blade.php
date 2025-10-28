<style>
    html,
    body {
        position: relative;
        height: 100%;
    }

    body {
        background: #eee;
        font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
        font-size: 14px;
        color: #000;
        margin: 0;
        padding: 0;
    }

    swiper-container {
        width: 100%;
        height: 100%;
    }

    swiper-slide {
        text-align: center;
        font-size: 14px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .mySwiper.menu-top {
        margin-inline: 0px !important;
    }

    :host {
        position: relative;
        display: block;
        margin-left: 0 !important;
        margin-right: 0 !important;
        z-index: 1;
    }

    .swiper-button-next svg,
    .swiper-button-prev svg {
        width: 100%;
        height: 60% !important;
        object-fit: contain;
        transform-origin: center;
    }

    .swiper-button-next,
    .swiper-rtl .swiper-button-prev {
        right: var(--swiper-navigation-sides-offset, -5px) !important;
        left: auto;
    }

    .mySwiper.menu-top a {
        padding-block: 6px;
    }

    .mySwiper.menu-top a.active {
        color: #44225c !important;
        border-bottom: 2px solid #44225c;
    }
   
.custom-tooltip .tooltip-inner {
    background-color: #014d41 !important; 
    color: #fff !important; 
}


.custom-tooltip .tooltip-arrow::before {
    border-bottom-color: #014d41 !important; 
}
</style>

<div class="page-header">
    <div class="header-wrapper row">


        <svg class="stroke-icon toggle-sidebar">
            <use class="status_toggle middle sidebar-toggle" href="{{ asset('fonts/icons/icon-sprite.svg#Grid') }}">
            </use>
        </svg>
        <!--
        <form class="col-auto form-inline search-full" action="#" method="get">
            <div class="form-group">
              <div class="Typeahead Typeahead--twitterUsers">
                <div class="u-posRelative">
                  <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Type to Search .." name="q" title="" autofocus>
                  <svg class="search-bg svg-color">
                    <use href="{{ asset('fonts/icons/icon-sprite.svg#Search') }}"></use>
                  </svg>
                </div>
                <div class="Typeahead-menu"></div>
              </div>
            </div>
          </form>  -->
        <!-- strat menu carousel -->






        @if (isset($menuData[1]))
            @foreach ($menuData[1]->menu as $menu)
                @if (
                    (isset($menu->submenu) &&
                        is_array($menu->submenu) &&
                        collect($menu->submenu)->pluck('activeRoute')->flatten()->contains(Route::currentRouteName())) ||
                        (isset($menu->submenu) &&
                            is_array($menu->submenu) &&
                            collect($menu->submenu)->pluck('subsubmenu')->flatten()->pluck('activeRoute')->flatten()->contains(Route::currentRouteName())))
                    @php
                        // Initialize active menu state
                        $activemenu = '';

                        // Loop through each submenu item
                        foreach ($menu->submenu as $submenu) {
                            // Initialize subsubmenu as null
                            $subsubmenu = null;

                            // Check if each submenu item has a subsubmenu
                            if (isset($submenu->subsubmenu) && is_array($submenu->subsubmenu)) {
                                // Map through subsubmenu to add URLs
                                $subsubmenu = array_map(function ($item) {
                                    if (isset($item->route)) {
                                        $item->url = route($item->route);
                                    }
                                    return $item;
                                }, $submenu->subsubmenu);
                            }

                            // Check for active state based on submenu or subsubmenu activeRoute array match
                            if (
                                (isset($submenu->activeRoute) &&
                                    is_array($submenu->activeRoute) &&
                                    in_array(Route::currentRouteName(), $submenu->activeRoute)) ||
                                ($subsubmenu &&
                                    collect($subsubmenu)
                                        ->pluck('activeRoute')
                                        ->flatten()
                                        ->contains(Route::currentRouteName()))
                            ) {
                                $activemenu = 'active';
                                break;
                            }
                        }
                    @endphp

                    {{-- Display active submenu details if applicable --}}
                    @if ($activemenu)
                        <swiper-container id="menuTopExist" class="mySwiper menu-top col-md-6 start f-w-700 p-0"
                            navigation="true" space-between="8" slides-per-view="8">

                            @if ($subsubmenu)
                                @foreach ($subsubmenu as $item)
                                    @if (auth()->user()->hasPermission($item->permission_key))
                                        <!-- Permission check for the submenu -->
                                        <swiper-slide>
                                            <a class="{{ in_array(Route::currentRouteName(), $item->activeRoute ?? []) ? 'active' : '' }}"
                                                href="{{ $item->url }}">
                                                <i data-feather="{{ $item->icon }}"></i>
                                                {{ __('locale.' . $item->name) }}
                                            </a>
                                        </swiper-slide>
                                    @endif
                                @endforeach
                            @endif
                        </swiper-container>
                    @endif
                @endif
            @endforeach
        @endif


        <swiper-container id="menuTop" class="mySwiper menu-top col-md-6 start f-w-700   p-0 d-none "
            navigation="true" space-between="8" slides-per-view="8">

        </swiper-container>
        <script src="{{ asset('cdn/swiper-element-bundle.min.js') }}"></script>

        <!-- end menu carousel -->
        <div class="nav-right col-auto pull-right right-header p-2" id="nav-right">
            <ul class="nav-menus">
                <li class="serchinput">
                    <div class="serchbox">

                        <svg class="half-circle svg-fill">
                            <use href="{{ asset('fonts/icons/icon-sprite.svg#Search') }}"></use>
                        </svg>
                    </div>
                    <div class="form-group search-form">
                        <input type="text" placeholder="Search here...">
                    </div>
                </li>



                @if (auth()->user()->hasPermission('task.list'))
                <li class="nav-item d-block">
    <a class="nav-link" href="{{ route('admin.task.calendar') }}"
       data-bs-toggle="tooltip" 
       data-bs-placement="bottom" 
       data-bs-custom-class="custom-tooltip"
       title="{{ __('locale.Calendar') }}">
       <i class="ficon" data-feather="calendar"></i>
    </a>
</li>

<li class="nav-item d-block">
    <a class="nav-link" href="{{ route('admin.task.assigned_to_me') }}"
       data-bs-toggle="tooltip" 
       data-bs-placement="bottom" 
       data-bs-custom-class="custom-tooltip"
       title="Todo">
       <i class="ficon" data-feather="check-square"></i>
    </a>
</li>

                @endif

                </script>


                <!-- <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ route('admin.dashboard') }}"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('locale.Home') }}"><i
                            class="ficon" data-feather="home"></i></a></li> -->



                {{-- This will changed to be Real time notification --}}
                @if (Auth::check())
                    <li class="onhover-dropdown ">
                        <div class="notification-box">
                            <i class="ficon" data-feather="bell"></i>
                            <span class="badge rounded-pill bg-danger badge-up"
                                style="top: -12px !important;">{{ $notificationsData['countUnreadNotification'] }}</span>
                        </div>
                        <ul class="profile-dropdown onhover-show-div onclick-show-div d-block"
                            style="width: 330px !important;">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header d-flex">
                                    <h4 class="notification-title mb-0 me-auto">{{ __('locale.Notifications') }}</h4>
                                    <div class="badge rounded-pill badge-light-primary">
                                        {{ $notificationsData['countNotification'] }} {{ __('locale.ALL') }}
                                    </div>
                                </div>
                            </li>
                            <li class="scrollable-container media-list">
                                @foreach ($notificationsData['notifications'] as $notification)
                                    <a class="d-flex  {{ notification_type($notification->is_read) }}"
                                        id="notification{{ $notification->id }}" href="javascript:void(0)"
                                        link="{{ notification_meta($notification->meta, 'link') }}"
                                        onclick="makeNotificationRead({{ $notification->id }})">
                                        <div class="list-item d-flex align-items-start">
                                            <div class="me-1">
                                                <div class="avatar">
                                                    <img src="{{ asset('images/notification.png') }}" alt="avatar"
                                                        width="32" height="32">
                                                </div>
                                            </div>
                                            <div class="list-item-body flex-grow-1">
                                                <p class="media-heading">{!! $notification->message !!}</p>
                                                <small class="notification-text">
                                                    {{ $notification->created_at }}</small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </li>
                            @if ($notificationsData['countNotification'] > 0)
                                <li class="dropdown-menu-footer">
                                    <a class="btn btn-primary w-100"
                                        href="{{ route('notifications.more') }}">{{ __('locale.ReadAllNotifications') }}
                                    </a>
                                </li>
                            @endif


                        </ul>




                        <!-- <div class=" profile-dropdown onhover-show-div notification-dropdown">
                            <ul class="profile-dropdown onhover-show-divdropdown-menu dropdown-menu-media dropdown-menu-end ">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header d-flex">
                                        <h4 class="notification-title mb-0 me-auto">{{ __('locale.Notifications') }}</h4>
                                        <div class="badge rounded-pill badge-light-primary">
                                            {{ $notificationsData['countNotification'] }} {{ __('locale.ALL') }}
                                        </div>
                                    </div>
                                </li>
                                <li class="scrollable-container media-list">
                                    @foreach ($notificationsData['notifications'] as $notification)
<a class="d-flex  {{ notification_type($notification->is_read) }}"
                                            id="notification{{ $notification->id }}" href="javascript:void(0)"
                                            link="{{ notification_meta($notification->meta, 'link') }}"
                                            onclick="makeNotificationRead({{ $notification->id }})">
                                            <div class="list-item d-flex align-items-start">
                                                <div class="me-1">
                                                    <div class="avatar">
                                                        <img src="{{ asset('images/notification.png') }}" alt="avatar"
                                                            width="32" height="32">
                                                    </div>
                                                </div>
                                                <div class="list-item-body flex-grow-1">
                                                    <p class="media-heading">{!! $notification->message !!}</p>
                                                    <small class="notification-text">
                                                        {{ $notification->created_at }}</small>
                                                </div>
                                            </div>
                                        </a>
@endforeach
                                </li>
                                @if ($notificationsData['countNotification'] > 0)
<li class="dropdown-menu-footer">
                                        <a class="btn btn-primary w-100"
                                            href="{{ route('notifications.more') }}">{{ __('locale.ReadAllNotifications') }}
                                        </a>
                                    </li>
@endif
                            </ul>
                        </div> -->
                    </li>
                @endif

                {{--
                <li class="nav-item dropdown dropdown-user onhover-dropdown langdrop">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                        data-bs-toggle="dropdown" aria-haspopup="true">
                        <div class="user-nav d-sm-flex d-none">
                            <span class="selected-language">
                                @foreach ($languages as $language => $name)
                                @if (session()->has('locale'))
                                @if (session()->get('locale') == $language)
                                {{ trans('locale.' . $name) }}
                                @endif
                                @else
                                @if (app()->getLocale() == $language)
                                {{ trans('locale.' . $name) }}
                                @endif
                                @endif
                                @endforeach
                            </span>
                        </div>

                    </a>
                    <div class="dropdown-menu dropdown-menu-end onhover-show-div">

                        @foreach ($languages as $language => $name)
                        <a class="dropdown-item" href="{{ url()->current() . '?lang=' . $language }}">
                            {{ trans('locale.' . $name) }}</a>
                        @endforeach


                    </div>
                </li> --}}

                <!-- <li class="language-nav onhover-dropdown langdrop">
                    <div class="translate_wrapper">
                        <div class="current_lang">
                            <div class="lang">
                                <span class="lang-txt">
                                    @foreach ($languages as $language => $name)
@if (session()->has('locale'))
@if (session()->get('locale') == $language)
{{ trans('locale.' . $name) }}
@endif
@else
@if (app()->getLocale() == $language)
{{ trans('locale.' . $name) }}
@endif
@endif
@endforeach
                                </span>
                            </div>
                        </div>

                        <ul class="profile-dropdown onhover-show-div">
                            @foreach ($languages as $language => $name)
<li>
                                    <a class="dropdown-item" href="{{ url()->current() . '?lang=' . $language }}">
                                        {{ trans('locale.' . $name) }}</a>
                                </li>
@endforeach




                        </ul>


                    </div>
                </li> -->
                <li class="language-nav onhover-dropdown langdrop">
                    <div class="translate_wrapper">
                        <a class="lang-switch"
                            href="{{ url()->current() . '?lang=' . (app()->getLocale() == 'en' ? 'ar' : 'en') }}">
                            {{ app()->getLocale() == 'en' ? 'AR' : 'EN' }}
                        </a>
                    </div>
                </li>



                <li class="profile-nav onhover-dropdown pe-0 ">
                    <div class="d-flex align-items-center justify-content-center profile-media ">
                        <div class=" user">
                            <div>
                                <i class="me-50" data-feather="user" style="width: 16px; height: 16px;"></i>
                                @if (Auth::check())
                                    {{ Auth::user()->name }}
                                @else
                                    {{ session()->get('locale') == 'ar' ? getSystemSetting('APP_OWNER_AR', 'اسم الشركة') : getSystemSetting('APP_OWNER_EN', 'Company Name') }}
                                @endif
                                <svg style="width: 16px !important; ">
                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#header-arrow-down') }}">
                                    </use>
                                </svg>
                            </div>
                            <!-- <p class="mb-0 font-nunito"> {{ Auth::user()->role->name }}</p> -->
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li>
                            <a class="dropdown-item"
                                href="{{ Route::has('admin.configure.userprofile.index') ? route('admin.configure.userprofile.index') : 'javascript:void(0)' }}">
                                <i class="me-50" data-feather="user"></i> Profile
                            </a>
                        </li>


                        <li>

                            @if (Auth::check())
                                <a class="dropdown-item" href="javascript:"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="me-50" data-feather="power"></i> Logout
                                </a>
                                <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                    @csrf
                                </form>
                            @else
                                <a class="dropdown-item"
                                    href="{{ Route::has('login') ? route('login') : 'javascript:void(0)' }}">
                                    <i class="me-50" data-feather="log-in"></i> Login
                                </a>
                            @endif


                        </li>

                    </ul>
                </li>
            </ul>
        </div>

    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

</script>