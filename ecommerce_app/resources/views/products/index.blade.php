@extends('layouts.app')

@section('content')

<h1 class="mt-4 mb-4">Product List</h1>
<h2 class="mt-4">Bulk Upload Products via CSV</h2>

<form action="{{ route('products.bulk-upload') }}" method="POST"    enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="csv_file"></label>
        <input type="file" name="csv_file" class="form-control" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Upload Products</button>
</form>

<br>
<br>

<a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

<table class="table table-striped">

    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock Status</th>
            <th>Images</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->title }}</td>
            <td>{{ $product->description }}</td>
            <td>${{ $product->price }}</td>

            <td>
                @if ($product->latestVariant() && $product->latestVariant()->stock_level > 0)
                In Stock
                @else
                Out of Stock
                @endif
            </td>

            <td>
                @if ($product->images)
                @foreach (json_decode($product->images) as $image)
                <img src="{{ asset('storage/images/'.$image) }}" width="100" class="mb-2">
                @endforeach
                @endif
            </td>

            <td>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>

                <a href="{{ route('products.variants.create', $product->id) }}" class="btn btn-info btn-sm">Add Variants</a>
            </td>

        </tr>
        @endforeach
    </tbody>

</table>
@endsection