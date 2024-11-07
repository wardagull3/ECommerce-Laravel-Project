<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LowStockNotification;

class AdminNotificationController extends Controller
{
    public function lowStockNotifications()
{
    $notifications = LowStockNotification::with('product')->get();
    return view('admin.notifications', compact('notifications'));
}
    }
