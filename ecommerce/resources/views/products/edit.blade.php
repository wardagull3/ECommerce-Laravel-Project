@extends('layouts.app')

@section('content')
<h1 class="mt-4 mb-4">Edit Product</h1>

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" value="{{ $product->title }}" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
    </div>

    <div class="form-group">
        <label for="sku">SKU</label>
        <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" required>
    </div>

    <div class="form-group">
        <label for="stock_status">Stock Status</label>
        <select name="stock_status" class="form-control" required>
            <option value="In Stock" {{ $product->stock_status == 'In Stock' ? 'selected' : '' }}>In Stock</option>
            <option value="Out of Stock" {{ $product->stock_status == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
        </select>
    </div>

    <h3>Existing Images:</h3>
    @if ($product->images)
        @foreach (json_decode($product->images) as $image)
            <img src="{{ asset('storage/images/'.$image) }}" width="100" class="mb-2">
        @endforeach
    @endif

    <div class="form-group">
        <label for="images">Upload New Images (optional)</label>
        <input type="file" name="images[]" class="form-control-file" multiple>
    </div>

    <div class="form-group">
        <label for="categories">Select Categories</label>
        <select name="categories[]" class="form-control" multiple required>
            @if ($categories && $categories->isNotEmpty()) <!-- Check if categories are present -->
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->categories->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            @else
                <option value="">No categories available</option>
            @endif
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
</form>


@endsection
