<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Notifications\OrderNotification;

class OrderController extends Controller
{
    // Display all orders
    public function index()
    {
        $orders = Order::with('user')->get(); // Retrieve all orders
        return view('admin.orders.index', compact('orders'));
    }

    // Update the status of an order
    public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|string|in:Pending,Processing,Shipped,Delivered',
    ]);

    $order->status = $request->status;
    $order->save();

    // Send notification based on the updated status
    if ($order->status === 'Pending') {
        $order->user->notify(new OrderNotification($order, 'placed'));
    } elseif ($order->status === 'Shipped') {
        $order->user->notify(new OrderNotification($order, 'shipped'));
    } elseif ($order->status === 'Delivered') {
        $order->user->notify(new OrderNotification($order, 'delivered'));
    }

    return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully!');
}
}
