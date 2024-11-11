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

<h1 class="mt-4 mb-4">Add New Category</h1>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Category Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
    </div>

    <button type="submit" class="btn btn-success">Create Category</button>
</form>
@endsection
