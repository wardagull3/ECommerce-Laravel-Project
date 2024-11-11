<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class CustomerController extends Controller
{
    public function orderHistory()
    {
        $orders = Auth::user()->orders()->with('orderItems.product')->get();
        return view('customer.orders.index', compact('orders'));
    }

    public function showOrder($id)
{
    $order = Order::with('orderItems.product')->findOrFail($id);
    return view('customer.orders.show', compact('order'));
}
}
