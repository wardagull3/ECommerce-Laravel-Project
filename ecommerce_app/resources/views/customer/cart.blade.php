<!-- resources/views/customer/cart.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item->product->title }}</td>
                <td>
                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                        @csrf
                        <input type="number"
                            name="quantity"
                            value="{{ $item->quantity }}"
                            min="1"
                            max="{{ optional($item->product->latestVariant())->stock_level }}"
                            class="form-control"
                            style="width: 60px; display: inline;">
                        <button type="submit" class="btn btn-link">Update</button>
                    </form>
                </td>
                <td>
                    @php
                    $isOnSale = $item->product->is_on_sale && $item->product->discount_percentage > 0;
                    $currentDate = now()->toDateString();
                    $isOnSaleValid = $isOnSale && $currentDate >= $item->product->discount_start_date && $currentDate <= $item->product->discount_end_date;

                        // Calculate the discounted price if the product is on sale
                        if ($isOnSaleValid) {
                        $discountedPrice = $item->product->price - ($item->product->price * ($item->product->discount_percentage / 100));
                        echo '$' . number_format($discountedPrice, 2);
                        } else {
                        echo '$' . number_format($item->product->price, 2);
                        }
                        @endphp
                </td>
                <td>
                    @php
                    $totalPrice = $isOnSaleValid ? $discountedPrice * $item->quantity : $item->product->price * $item->quantity;
                    echo '$' . number_format($totalPrice, 2);
                    @endphp
                </td>
                <td>
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Total: ${{ number_format($cartItems->sum(fn($item) => 
        ($item->product->is_on_sale && $currentDate >= $item->product->discount_start_date && $currentDate <= $item->product->discount_end_date)
            ? ($item->product->price - ($item->product->price * ($item->product->discount_percentage / 100))) * $item->quantity
            : $item->product->price * $item->quantity
    ), 2) }}</h4>
    <!-- Button for confirming order -->
    <a href="{{ route('customer.checkout.shipping') }}" class="btn btn-primary">Confirm Order</a>
</div>

@endsection