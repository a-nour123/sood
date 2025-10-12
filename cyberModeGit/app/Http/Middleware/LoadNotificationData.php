<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Notific; 
use Illuminate\Http\Request;


class LoadNotificationData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::id();

            $countNotification = Notific::getNotificationCount($userId, 'all');

            $countUnreadNotification = Notific::getNotificationCount($userId, 'unread');

            $notifications = Notific::getNotifications($userId, ['read_status' => 'all', 'items_per_page' => 5]);

            $notificationsData = [
                'countNotification' => $countNotification,
                'countUnreadNotification' => $countUnreadNotification,
                'notifications' => $notifications,
            ];

            // Share data with all views
            view()->share('notificationsData', $notificationsData);


        }

        return $next($request);
    }
}