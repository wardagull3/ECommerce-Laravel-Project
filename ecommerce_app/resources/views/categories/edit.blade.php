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


<h1 class="mt-4 mb-4">Edit Category</h1>

<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Category Name</label>
        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update Category</button>
</form>
@endsection
