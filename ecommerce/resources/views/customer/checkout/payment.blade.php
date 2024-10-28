<!-- resources/views/customer/checkout/payment.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Details</h2>
    <form action="{{ route('customer.checkout.review') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Select Payment Method</label>
            <div>
                <input type="radio" name="payment_method" value="cod" required onclick="toggleCardInfo(false)"> Cash on Delivery
            </div>
            <div>
                <input type="radio" name="payment_method" value="card" onclick="toggleCardInfo(true)"> Credit/Debit Card
            </div>
        </div>

        <!-- Card Information Fields (hidden by default) -->
        <div id="card-info" style="display: none; margin-top: 15px;">
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" name="card_number" class="form-control" maxlength="16" placeholder="Enter card number">
            </div>
            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="text" name="expiry_date" class="form-control" placeholder="MM/YY">
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" name="cvv" class="form-control" maxlength="3" placeholder="Enter CVV">
            </div>
            <div class="form-group">
                <label for="cardholder_name">Cardholder Name</label>
                <input type="text" name="cardholder_name" class="form-control" placeholder="Name on card">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Review Order</button>
    </form>
</div>

<script>
    function toggleCardInfo(show) {
        document.getElementById('card-info').style.display = show ? 'block' : 'none';
    }
</script>
@endsection
