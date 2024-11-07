<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
{
    $cartItems = Auth::user()->cartItems()->with('product')->get();
    return view('customer.cart', compact('cartItems'));
}


    public function add(Request $request, $productId)
    {
        $user = Auth::user();

        // Check if the cart item already exists
        $cartItem = $user->cartItems->where('product_id', $productId)->first();

        if ($cartItem) {
            // If the item is already in the cart, increment the quantity
            $cartItem->increment('quantity');
        } else {
            // If it's a new item, create a new CartItem entry
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('customer.cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, $cartId)
    {
        $cartItem = Cart::find($cartId);

        $productVariant = $cartItem->product->variants()->latest()->first();

        if (!$productVariant) {
            return redirect()->route('customer.cart.index')->with('error', 'Product variant not found.');
        }

        $availableStock = $productVariant->stock_level;

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $availableStock,
        ], [
            'quantity.max' => 'The quantity cannot exceed the available stock of ' . $availableStock,
        ]);
        

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('customer.cart.index')->with('success', 'Cart updated.');
    }

    public function remove($cartId)
    {
        Cart::destroy($cartId);

        return redirect()->route('customer.cart.index')->with('success', 'Item removed from cart.');
    }
}
