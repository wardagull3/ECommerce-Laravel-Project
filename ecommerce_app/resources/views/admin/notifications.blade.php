@extends('layouts.app')

@section('content')
<h1>Low Stock Notifications</h1>
<table class="table">
    <thead>
        <tr>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Stock Level</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($notifications as $notification)
        <tr>
            <td>{{ $notification->product->id }}</td>
            <td>{{ $notification->product->title }}</td>
            <td>{{ $notification->stock_level }}</td>
            <td>
            <a href="{{ route('products.variants.create', $notification->product->id) }}" class="btn btn-info btn-sm">ReStock</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection