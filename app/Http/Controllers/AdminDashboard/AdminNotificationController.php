<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Admin;


class AdminNotificationController extends Controller
{
     
      
    public function index()
    {
         $admin = Admin::find(auth()->id());
         return response()->json([
            'Notifications'=>$admin->notifications
         ]);
    }

    public function unread()
    {
         $admin = Admin::find(auth()->id());
         return response()->json([
            'Notifications'=>$admin->unreadNotifications
         ]);
    }

    public function markread()
    {
         $admin = Admin::find(auth()->id());

         foreach ($admin->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
         return response()->json([
            'message'=>'success'
         ]);
    }
      
      
}
