<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Menandai notifikasi sebagai "sudah dibaca".
     */
    public function markAsRead(Request $request)
    {
        // 1. Jika ada ID notifikasi spesifik yang dikirim melalui request...
        if ($request->id) {
            // Cari notifikasi milik user yang sedang login berdasarkan ID tersebut.
            $notification = Auth::user()->notifications()->where('id', $request->id)->first();
            
            // Jika ditemukan, panggil method markAsRead() bawaan notifikasi Laravel.
            if ($notification) {
                $notification->markAsRead();
            }
            
            // Kembali ke halaman sebelumnya.
            return back();
        }

        // 2. Jika tidak ada ID spesifik, berarti user menekan tombol "Tandai Semua Dibaca".
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    }
}
