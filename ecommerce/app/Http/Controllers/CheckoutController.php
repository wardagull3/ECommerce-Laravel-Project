<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Notifications\OrderNotification;

class CheckoutController extends Controller
{
    public function shipping()
    {
        return view('customer.checkout.shipping');
    }

    public function payment(Request $request)
    {
        session([
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
        ]);

        return view('customer.checkout.payment');
    }

    public function review(Request $request)
    {
        session(['payment_method' => $request->payment_method]);

        $cartItems = Auth::user()->cartItems()->with('product')->get();
        $totalPrice = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('customer.checkout.review', compact('cartItems', 'totalPrice'));
    }

    public function complete()
    {
        $user = Auth::user();
    $cartItems = $user->cartItems()->with('product')->get();

    $totalPrice = $cartItems->sum(function($item) {
        return $item->product->price * $item->quantity;
    });

     // Create the order
     $order = Order::create([
        'user_id' => $user->id,
        'total_price' => $totalPrice,
        'status' => 'Pending',
    ]);

    // Send order placed notification
    $order->user->notify(new OrderNotification($order, 'placed'));

    foreach ($cartItems as $cartItem) {
        $order->orderItems()->create([
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->product->price, 
        ]);
    }


        Auth::user()->cartItems->each->delete();
        return redirect()->route('customer.products.index')->with('success', 'Order placed successfully!');
    }
}
