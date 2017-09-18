<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;
use Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('notifications.index',compact('user'));
    }

    public function show(DatabaseNotification $notification)
    {
        $notification->markAsRead();
        return redirect(Request::query('redirect_url'));
    }

    public function read()
    {
        $user = Auth::id();
        $all =  DatabaseNotification::where('notifiable_id',$user)->get();
        $all->each(function ($value) {
            $value->markAsRead();
        });
        return redirect('/notifications');
    }

}
