<!-- resources/views/customer/checkout/shipping.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Shipping Details</h2>
    <form action="{{ route('customer.checkout.payment') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="postal_code">Postal Code</label>
            <input type="text" name="postal_code" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Continue to Payment</button>
    </form>
</div>
@endsection
