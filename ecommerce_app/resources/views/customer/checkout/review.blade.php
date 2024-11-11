@extends('layouts.app')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <h2>Review Your Order</h2>
    <h4>Shipping Details</h4>
    <p>Address: {{ session('address') }}</p>
    <p>City: {{ session('city') }}</p>
    <p>Postal Code: {{ session('postal_code') }}</p>
    <p>Phone: {{ session('phone') }}</p>

    <h4>Payment Method</h4>
    <p>{{ session('payment_method') == 'cod' ? 'Cash on Delivery' : 'Credit/Debit Card' }}</p>

    <h4>Cart Items</h4>
    @foreach ($cartItems as $item)
    <div>
        {{ $item->product->title }} - Quantity: {{ $item->quantity }} - Price: ${{ $item->product->price * $item->quantity }}
    </div>
    @endforeach
    <p>Total: ${{ number_format($totalPrice, 2) }}</p>

    <form action="{{ route('customer.checkout.complete') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Confirm Order</button>
    </form>
</div>

@endsection