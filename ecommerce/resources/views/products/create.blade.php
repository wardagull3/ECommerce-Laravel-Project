@extends('layouts.app')

@section('content')
<h1 class="mt-4 mb-4">Add New Product</h1>

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" placeholder="Title" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" placeholder="Description" required></textarea>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" class="form-control" placeholder="Price" required>
    </div>

    <div class="form-group">
        <label for="sku">SKU</label>
        <input type="text" name="sku" class="form-control" placeholder="SKU" required>
    </div>

    <div class="form-group">
        <label for="stock_status">Stock Status</label>
        <select name="stock_status" class="form-control" required>
            <option value="In Stock">In Stock</option>
            <option value="Out of Stock">Out of Stock</option>
        </select>
    </div>

    <div class="form-group">
        <label for="images">Product Images</label>
        <input type="file" name="images[]" class="form-control-file" multiple>
    </div>

    <div class="form-group">
        <label for="categories">Select Categories</label>
        <select name="categories[]" class="form-control" multiple required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-success">Add Product</button>
</form>



@endsection
