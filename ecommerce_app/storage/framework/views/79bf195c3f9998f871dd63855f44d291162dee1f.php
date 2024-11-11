

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Review Your Order</h2>
    <h4>Shipping Details</h4>
    <p>Address: <?php echo e(session('address')); ?></p>
    <p>City: <?php echo e(session('city')); ?></p>
    <p>Postal Code: <?php echo e(session('postal_code')); ?></p>
    <p>Phone: <?php echo e(session('phone')); ?></p>

    <h4>Payment Method</h4>
    <p><?php echo e(session('payment_method') == 'cod' ? 'Cash on Delivery' : 'Credit/Debit Card'); ?></p>

    <h4>Cart Items</h4>
    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div>
        <?php echo e($item->product->title); ?> - Quantity: <?php echo e($item->quantity); ?> - Price: $<?php echo e($item->product->price * $item->quantity); ?>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <p>Total: $<?php echo e(number_format($totalPrice, 2)); ?></p>

    <form action="<?php echo e(route('customer.checkout.complete')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <button type="submit" class="btn btn-success">Confirm Order</button>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/customer/checkout/review.blade.php ENDPATH**/ ?>