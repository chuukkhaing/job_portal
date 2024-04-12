<?php

namespace App\Http\Controllers\API\Seeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seeker\Seeker;

class SeekerNotificationController extends Controller
{
    public function getNotification(Request $request)
    {
        $seeker = Seeker::whereId($request->user()->id)->first();
        $notificationCount = $seeker->unreadNotifications()->count();
        $notifications = $seeker->notifications()->select('id','data','created_at','read_at')->orderBy('created_at','desc')->get();;
        return response()->json([
            'status' => 'success',
            'notificationCount' => $notificationCount,
            'notifications' => $notifications
        ], 200);
    }

    public function readNoti(Request $request)
    {
        $this->validate($request,[
            'notification_id' => 'required'
        ]);
        $seeker = Seeker::whereId($request->user()->id)->first();
        $noti = $seeker->notifications->whereIn('id', $request->notification_id)->markAsRead();
        if($noti) {
            return response()->json([
                'status' => 'success'
            ], 200);
        }else {
            return response()->json([
                'status' => 'Notification ID not found.'
            ], 500);
        }
    }
}
