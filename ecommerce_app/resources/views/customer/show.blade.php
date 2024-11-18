@extends('layouts.app')

@section('content')
<style>
    .image-box {
        max-height: 150px;
        overflow-y: auto;
        display: flex;
        flex-wrap: wrap;
    }

    .image-box img {
        width: 48%;
        margin: 2px;
        border-radius: 4px;
    }
</style>
<div class="container">
    <h1>{{ $product->title }}</h1>
    @if ($product->images)
    <div class="image-box mb-3">
        @foreach (json_decode($product->images) as $image)
        <img src="{{ asset('storage/images/'.$image) }}" class="img-thumbnail" alt="Product Image">
        @endforeach
    </div>
    @endif

    <p><strong>Description:</strong> {{ $product->description }}</p>
    <p><strong>Price:</strong> ${{ $product->price }}</p>
    <p><strong>Stock Status:</strong>
        @if ($product->latestVariant() && $product->latestVariant()->stock_level > 0)
        In Stock
        @else
        Out of Stock
        @endif
    </p>

    @if ($product->is_on_sale && $product->discount_percentage > 0)
    @php
    $currentDate = now()->toDateString();
    $isOnSale = $currentDate >= $product->discount_start_date && $currentDate <= $product->discount_end_date;
        @endphp
        @if ($isOnSale)
        @php
        $discountedPrice = $product->price - ($product->price * ($product->discount_percentage / 100));
        @endphp
        <p class="text-danger">Sale Price: ${{ number_format($discountedPrice, 2) }}</p>
        <p><strong>{{ $product->discount_percentage }}% off</strong></p>
        @endif
        @endif

        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
</div>
@endsection