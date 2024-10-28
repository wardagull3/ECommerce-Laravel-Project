@extends('layouts.app')

@section('content')

<h1 class="mt-4 mb-4">Add Variants</h1>

<form action="{{ route('products.variants.store', $product->id) }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="size">Size</label>
        <input type="text" name="size" class="form-control" placeholder="Size (optional)">
    </div>

    <div class="form-group">
        <label for="color">Color</label>
        <input type="text" name="color" class="form-control" placeholder="Color (optional)">
    </div>

    <div class="form-group">
        <label for="sku">SKU</label>
        <input type="text" name="sku" class="form-control" placeholder="Enter SKU" required>
    </div>

    <div class="form-group">
        <label for="stock_level">Stock Level</label>
        <input type="number" name="stock_level" class="form-control" placeholder="Stock Level" required>
    </div>

    <button type="submit" class="btn btn-success">Add Variant</button>
</form>

@endsection
