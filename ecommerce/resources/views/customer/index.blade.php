<!-- resources/views/customer/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Available Products</h1>
    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                <!-- Display the product image from public/storage/images/ -->
                @if ($product->images)
                @foreach (json_decode($product->images) as $image)
                <img src="{{ asset('storage/images/'.$image) }}" width="100" class="mb-2">
                @endforeach
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">Price: ${{ $product->price }}</p>
                    <p class="card-text">Stock Status: {{ $product->stock_status }}</p>
                    
                    <!-- Only show the Add to Cart button if the stock status is 'In Stock' -->
                    @if ($product->stock_status === 'In Stock')
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection