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
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 60px; display: inline;">
                            <button type="submit" class="btn btn-link">Update</button>
                        </form>
                    </td>
                    <td>${{ $item->product->price }}</td>
                    <td>${{ $item->product->price * $item->quantity }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Total: ${{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}</h4>
<!--button for confirming order -->
    <a href="{{ route('customer.checkout.shipping') }}" class="btn btn-primary">Confirm Order</a>


</div>
@endsection
