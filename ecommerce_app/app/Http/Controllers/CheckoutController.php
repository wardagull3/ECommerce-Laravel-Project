<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Notifications\OrderNotification;
use App\Events\OrderPlaced;
use App\Events\LowStockDetected;

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
        // Check if the product is on sale and if the sale is valid
        $isOnSale = $item->product->is_on_sale && $item->product->discount_percentage > 0;
        $currentDate = now()->toDateString();
        $isOnSaleValid = $isOnSale && $currentDate >= $item->product->discount_start_date && $currentDate <= $item->product->discount_end_date;

        // Calculate the discounted price if the product is on sale
        if ($isOnSaleValid) {
            $discountedPrice = $item->product->price - ($item->product->price * ($item->product->discount_percentage / 100));
            return $discountedPrice * $item->quantity;
        }

        // Return the original price if the product is not on sale
        return $item->product->price * $item->quantity;
    });

    return view('customer.checkout.review', compact('cartItems', 'totalPrice'));
}


    public function complete()
    {
        $user = Auth::user();
    $cartItems = $user->cartItems()->with('product')->get();

    $totalPrice = $cartItems->sum(function($item) {
        // Apply the discount logic for order completion
        $isOnSale = $item->product->is_on_sale && $item->product->discount_percentage > 0;
        $currentDate = now()->toDateString();
        $isOnSaleValid = $isOnSale && $currentDate >= $item->product->discount_start_date && $currentDate <= $item->product->discount_end_date;

        if ($isOnSaleValid) {
            $discountedPrice = $item->product->price - ($item->product->price * ($item->product->discount_percentage / 100));
            return $discountedPrice * $item->quantity;
        }

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

        // Deduct stock level
        $variant = $cartItem->product->latestVariant(); 
        if ($variant) {
            $variant->decrement('stock_level', $cartItem->quantity);

            if ($variant->stock_level < 10) {
                event(new LowStockDetected($cartItem->product));
            } 
        }


    }
    


        Auth::user()->cartItems->each->delete();
        return redirect()->route('customer.products.index')->with('success', 'Order placed successfully!');
    }
}
