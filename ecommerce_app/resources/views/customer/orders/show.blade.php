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
    <h2>Order Details - Order ID: {{ $order->id }}</h2>
    
    <p>Total Price: ${{ $order->total_price }}</p>
    <p>Status: {{ $order->status }}</p>
    <p>Order Date: {{ $order->created_at->format('Y-m-d') }}</p>


    <h4>Items:</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->title }}</td>
                <td>{{ $item->quantity }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
