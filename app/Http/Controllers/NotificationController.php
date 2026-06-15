<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        if ($request->id) {
            $notification = Auth::user()->notifications()->where('id', $request->id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
            return back();
        }

        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }
}
