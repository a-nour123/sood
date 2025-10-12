<li class="onhover-dropdown">
    <div class="notification-box">
        <i class="ficon" data-feather="bell"></i>
        <span class="badge rounded-pill bg-danger badge-up"
              style="top: -12px !important;">{{ $notificationsData['countUnreadNotification'] }}</span>
    </div>
    <ul class="profile-dropdown onhover-show-div onclick-show-div d-block" style="width: 330px !important;">
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
                <a class="d-flex {{ notification_type($notification->is_read) }}"
                   id="notification{{ $notification->id }}" href="javascript:void(0)"
                   link="{{ notification_meta($notification->meta, 'link') }}"
                   onclick="makeNotificationRead({{ $notification->id }})">
                    <div class="list-item d-flex align-items-start">
                        <div class="me-1">
                            <div class="avatar">
                                <img src="{{ asset('images/notification.png') }}" alt="avatar" width="32" height="32">
                            </div>
                        </div>
                        <div class="list-item-body flex-grow-1">
                            <p class="media-heading">{!! $notification->message !!}</p>
                            <small class="notification-text">{{ $notification->created_at }}</small>
                        </div>
                    </div>
                </a>
            @endforeach
        </li>
        @if ($notificationsData['countNotification'] > 0)
            <li class="dropdown-menu-footer">
                <a class="btn btn-primary w-100"
                   href="{{ route('notifications.more') }}">{{ __('locale.ReadAllNotifications') }}</a>
            </li>
        @endif
    </ul>
</li>
