@extends('layouts.app')

@section('content')
<h1 class="mt-4 mb-4">Add New Product</h1>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        \end{code}
        @foreach ($errors->all() as $error)
        \item {{ $error }}
        @endforeach
    </ul>
</div>
@endif
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

    <div class="form-group">
        <label for="is_on_sale">On Sale</label>
        <input type="checkbox" name="is_on_sale" class="form-control" value="0">
    </div>


    <div class="form-group">
        <label for="discount_percentage">Discount Percentage (%)</label>
        <input type="number" name="discount_percentage" class="form-control" placeholder="e.g: 50%"  step="0.01" min="0" max="100">
    </div>

    <div class="form-group">
        <label for="discount_start_date">Discount Start Date</label>
        <input type="date" name="discount_start_date" class="form-control" >
    </div>

    <div class="form-group">
        <label for="discount_end_date">Discount End Date</label>
        <input type="date" name="discount_end_date"class="form-control" >
    </div>

    <button type="submit" class="btn btn-success">Add Product</button>
</form>

@endsection