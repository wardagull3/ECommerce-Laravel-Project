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


<div class="container my-4">
    <h1 class="mt-4 mb-4 text-primary">Product List</h1>

    <div class="mb-5">
        <h2 class="mt-4 mb-3">Bulk Upload Products via CSV</h2>
        <form action="{{ route('products.bulk-upload') }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-light">
            @csrf
            <div class="form-group">
                <label for="csv_file" class="font-weight-bold">Upload CSV File</label>
                <input type="file" name="csv_file" class="form-control-file" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Upload Products</button>
        </form>
    </div>

    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Add New Product</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="thead-dark">
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
                    <td>{{ Str::limit($product->description, 100) }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        @if ($product->latestVariant() && $product->latestVariant()->stock_level > 0)
                        <span class="badge badge-success">In Stock</span>
                        @else
                        <span class="badge badge-danger">Out of Stock</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap">
                            @if ($product->images)
                                @foreach (json_decode($product->images) as $image)
                                    <img src="{{ asset('storage/images/'.$image) }}" alt="Product Image" class="img-thumbnail mr-1 mb-1" style="width: 100px; height: auto;">
                                @endforeach
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mb-1">Delete</button>
                        </form>
                        <a href="{{ route('products.variants.create', $product->id) }}" class="btn btn-info btn-sm mb-1">Add Variants</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="container">

    <div class="d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                @if ($products->previousPageUrl())
                    <li class="page-item">
                        <a href="{{ $products->previousPageUrl() }}" class="page-link">Previous</a>
                    </li>
                @endif

                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a href="{{ $products->nextPageUrl() }}" class="page-link">Next</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

@endsection
