

<?php $__env->startSection('content'); ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="container">
    <h2>Payment Details</h2>
    <form action="<?php echo e(route('customer.checkout.review')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label>Select Payment Method</label>
            <div>
                <input type="radio" name="payment_method" value="cod" required onclick="toggleCardInfo(false)"> Cash on Delivery
            </div>
            <div>
                <input type="radio" name="payment_method" value="card" onclick="toggleCardInfo(true)"> Credit/Debit Card
            </div>
        </div>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/customer/checkout/payment.blade.php ENDPATH**/ ?>