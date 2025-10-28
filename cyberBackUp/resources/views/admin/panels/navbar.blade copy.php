@if ($configData['mainLayoutType'] === 'horizontal' && isset($configData['mainLayoutType']))
<nav class="header-navbar navbar-expand-lg navbar navbar-fixed align-items-center navbar-shadow navbar-brand-center {{ $configData['navbarColor'] }}" data-nav="brand-center">
    <div class="navbar-header d-xl-block d-none w-100 text-center" style="left: 0;right:0; z-index: 0">
        <a class="navbar-brand justify-content-center" href="{{ route('admin.dashboard') }}">
            <h2 class="brand-text mb-0">
                {{ session()->get('locale') == 'ar' ? getSystemSetting('APP_OWNER_AR', 'اسم الشركة') : getSystemSetting('APP_OWNER_EN', 'Company Name') }}
            </h2>
        </a>
    </div>
    @else
    <nav class="header-navbar navbar navbar-expand-lg align-items-center {{ $configData['navbarClass'] }} navbar-light navbar-shadow {{ $configData['navbarColor'] }} {{ $configData['layoutWidth'] === 'boxed' && $configData['verticalMenuNavbarType'] === 'navbar-floating' ? 'container-xxl' : '' }}">
        @endif
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">
                    @if (auth()->user()->hasPermission('task.list'))
                    <li class="nav-item  d-block"><a class="nav-link" href="{{ route('admin.task.calendar') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('locale.Calendar') }}"><i class="ficon" data-feather="calendar"></i></a></li>
                    <li class="nav-item  d-block"><a class="nav-link" href="{{ route('admin.task.assigned_to_me') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Todo"><i class="ficon" data-feather="check-square"></i></a>
                    </li>
                    @endif
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{ route('admin.dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('locale.Home') }}"><i class="ficon" data-feather="home"></i></a></li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">

                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-bs-toggle="dropdown" aria-haspopup="true">
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
                    <div class="dropdown-menu dropdown-menu-end">

                        @foreach ($languages as $language => $name)
                        <a class="dropdown-item" href="{{ url()->current() . '?lang=' . $language }}">
                            {{ trans('locale.' . $name) }}</a>
                        @endforeach


                    </div>
                </li>



                @if (Auth::check())
                <li class="nav-item dropdown dropdown-notification me-25">
                    <a class="nav-link" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="ficon" data-feather="bell"></i>
                        <span class="badge rounded-pill bg-danger badge-up">{{ $notificationsData['countUnreadNotification'] }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
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
                            <a class="d-flex  {{ notification_type($notification->is_read) }}" id="notification{{ $notification->id }}" href="javascript:void(0)" link="{{ notification_meta($notification->meta, 'link') }}" onclick="makeNotificationRead({{ $notification->id }})">
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar">
                                            <img src="{{ asset('images/notification.png') }}" alt="avatar" width="32" height="32">
                                        </div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading">{!! $notification->message !!}</p>
                                        <small class="notification-text"> {{ $notification->created_at }}</small>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </li>
                        @if ($notificationsData['countNotification'] > 0)
                        <li class="dropdown-menu-footer">
                            <a class="btn btn-primary w-100" href="{{ route('notifications.more') }}">{{ __('locale.ReadAllNotifications') }} </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif
                <li class="nav-item dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);" data-bs-toggle="dropdown" aria-haspopup="true">
                        <div class="user-nav d-sm-flex d-none">
                            <span class="user-name fw-bolder">
                                @if (Auth::check())
                                {{ Auth::user()->name }}
                                @else
                                {{ session()->get('locale') == 'ar' ? getSystemSetting('APP_OWNER_AR', 'اسم الشركة') : getSystemSetting('APP_OWNER_EN', 'Company Name') }}
                                @endif
                            </span>
                            <span class="user-status">
                                {{ Auth::user()->role->name }}
                            </span>
                        </div>

                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <h6 class="dropdown-header">Manage Profile</h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ Route::has('admin.configure.userprofile.index') ? route('admin.configure.userprofile.index') : 'javascript:void(0)' }}">
                            <i class="me-50" data-feather="user"></i> Profile
                        </a>
                        {{-- @if (Auth::check() && Laravel\Jetstream\Jetstream::hasApiFeatures())
          <a class="dropdown-item" href="{{ route('api-tokens.index') }}">
                        <i class="me-50" data-feather="key"></i> API Tokens
                        </a>
                        @endif --}}
                        {{-- <a class="dropdown-item" href="#">
          <i class="me-50" data-feather="settings"></i> Settings
        </a>  --}}

                        {{-- @if (Auth::User() && Laravel\Jetstream\Jetstream::hasTeamFeatures())
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">Manage Team</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item"
            href="{{ Auth::user() ? route('teams.show', Auth::user()->currentTeam->id) : 'javascript:void(0)' }}">
                        <i class="me-50" data-feather="settings"></i> Team Settings
                        </a>
                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <a class="dropdown-item" href="{{ route('teams.create') }}">
                            <i class="me-50" data-feather="users"></i> Create New Team
                        </a>
                        @endcan

                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">
                            Switch Teams
                        </h6>
                        <div class="dropdown-divider"></div>
                        @if (Auth::user())
                        @foreach (Auth::user()->allTeams() as $team)
                        {{-- Below commented code read by artisan command while installing jetstream. !! Do not remove if you want to use jetstream. --}}

                        {{-- <x-jet-switchable-team :team="$team" />
            @endforeach
          @endif
        @endif  --}}
                        @if (Auth::check())
                        <a class="dropdown-item" href="javascript:" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="me-50" data-feather="power"></i> Logout
                        </a>
                        <form method="POST" id="logout-form" action="{{ route('logout') }}">
                            @csrf
                        </form>
                        @else
                        <a class="dropdown-item" href="{{ Route::has('login') ? route('login') : 'javascript:void(0)' }}">
                            <i class="me-50" data-feather="log-in"></i> Login
                        </a>
                        @endif
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!-- END: Header-->
