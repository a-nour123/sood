<?php

namespace App\Http\Controllers;

use App\Events\NotificationDataRealTime;
use Notific;
use DB;
use Auth;
class NotificationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    /**
     * Make notification read
     *
     * @return ajax respone
     */
    public function notificationMakeRead($id){
        Notific::markNotificationRead( Auth::user()->id, $id );
        broadcast(new NotificationDataRealTime());
        return response()->json($id,200);
    }
    public function notificationMore(){
        $notifications=$this->getNotification();
        // return $notifications;
        return view('admin.more-notification',compact('notifications'));
    }

    public function getNotification(){

        return Notific::getNotifications(Auth::user()->id, array('read_status' =>'all') );

    }

    public function listAllNotification()
    {
        try {
            $userId = Auth::id();
            $countNotification = Notific::getNotificationCount($userId, 'all');
            $countUnreadNotification = Notific::getNotificationCount($userId, 'unread');
            $notifications = Notific::getNotifications($userId, ['read_status' => 'all', 'items_per_page' => 10]);
            $notificationsData = [
                'countNotification' => $countNotification,
                'countUnreadNotification' => $countUnreadNotification,
                'notifications' => $notifications,
            ];
            $html = view('admin.panels.notifications', compact('notificationsData'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        } catch (\Exception $ex) {
            return response()->json(['success' => false,'message' => $ex->getMessage()]);
        }
    }
}
