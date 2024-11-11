

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
    <h1>Your Cart</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item->product->title); ?></td>
                <td>
                    <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type="number"
                            name="quantity"
                            value="<?php echo e($item->quantity); ?>"
                            min="1"
                            max="<?php echo e(optional($item->product->latestVariant())->stock_level); ?>"
                            class="form-control"
                            style="width: 60px; display: inline;">
                        <button type="submit" class="btn btn-link">Update</button>
                    </form>
                </td>
                <td>
                    <?php
                    $isOnSale = $item->product->is_on_sale && $item->product->discount_percentage > 0;
                    $currentDate = now()->toDateString();
                    $isOnSaleValid = $isOnSale && $currentDate >= $item->product->discount_start_date && $currentDate <= $item->product->discount_end_date;

                        // Calculate the discounted price if the product is on sale
                        if ($isOnSaleValid) {
                        $discountedPrice = $item->product->price - ($item->product->price * ($item->product->discount_percentage / 100));
                        echo '$' . number_format($discountedPrice, 2);
                        } else {
                        echo '$' . number_format($item->product->price, 2);
                        }
                        ?>
                </td>
                <td>
                    <?php
                    $totalPrice = $isOnSaleValid ? $discountedPrice * $item->quantity : $item->product->price * $item->quantity;
                    echo '$' . number_format($totalPrice, 2);
                    ?>
                </td>
                <td>
                    <form action="<?php echo e(route('cart.remove', $item->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <h4>Total: $<?php echo e(number_format($cartItems->sum(fn($item) => 
        ($item->product->is_on_sale && $currentDate >= $item->product->discount_start_date && $currentDate <= $item->product->discount_end_date)
            ? ($item->product->price - ($item->product->price * ($item->product->discount_percentage / 100))) * $item->quantity
            : $item->product->price * $item->quantity
    ), 2)); ?></h4>
    <a href="<?php echo e(route('customer.checkout.shipping')); ?>" class="btn btn-primary">Confirm Order</a>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/customer/cart.blade.php ENDPATH**/ ?>