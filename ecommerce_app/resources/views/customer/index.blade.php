<!-- resources/views/customer/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">

    <h1>Available Products</h1>
    <form action="{{ route('customer.search') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="query" placeholder="Search by name, category, or keyword">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- Filters Form -->
    <form action="{{ route('customer.filter') }}" method="GET" class="mb-4">
        <div class="form-row">
            <!-- Category Filter -->
            <div class="col-md-4">
                <select class="form-control" name="category">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Price Filter -->
            <div class="col-md-4">
                <select class="form-control" name="price">
                    <option value="">Select Price Range</option>
                    <option value="1" {{ request('price') == '1' ? 'selected' : '' }}>Under $50</option>
                    <option value="2" {{ request('price') == '2' ? 'selected' : '' }}>$50 - $100</option>
                    <option value="3" {{ request('price') == '3' ? 'selected' : '' }}>$100 - $200</option>
                    <option value="4" {{ request('price') == '4' ? 'selected' : '' }}>$200+</option>
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary mt-4" type="submit">Filter</button>
            </div>
        </div>
    </form>
    <form method="GET" action="{{ route('customer.sort') }}">
        <label for="sort">Sort by Price</label>
        <select name="sort" id="sort">
            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Low to High</option>
            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>High to Low</option>
        </select>

        <button type="submit">Sort</button>
    </form>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                @if ($product->images)
                @foreach (json_decode($product->images) as $image)
                <img src="{{ asset('storage/images/'.$image) }}" width="100" class="mb-2">
                @endforeach
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $product->title }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">Price: ${{ $product->price }}</p>
                    <p class="card-text">Stock Status: @if ($product->latestVariant() && $product->latestVariant()->stock_level > 0)
                        In Stock
                        @else
                        Out of Stock
                        @endif</p>

                    @if ($product->is_on_sale && $product->discount_percentage > 0)
                    @php
                    $currentDate = now()->toDateString();
                    $isOnSale = $currentDate >= $product->discount_start_date && $currentDate <= $product->discount_end_date;
                        @endphp
                        @if ($isOnSale)
                        @php
                        $discountedPrice = $product->price - ($product->price * ($product->discount_percentage / 100));
                        @endphp
                        <p style="color: red;">Sale Price: ${{ number_format($discountedPrice, 2) }}</p>
                        <p><strong>{{ $product->discount_percentage }}% off</strong></p>
                        @endif
                        @endif

                        <!-- Only show the Add to Cart button if the stock status is 'In Stock' -->
                        @if ($product->latestVariant() && $product->latestVariant()->stock_level > 0)
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