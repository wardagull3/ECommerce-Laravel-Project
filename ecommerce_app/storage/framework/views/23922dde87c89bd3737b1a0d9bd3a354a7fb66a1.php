

<?php $__env->startSection('content'); ?>
<style>
    .image-box {
        max-height: 150px;
        overflow-y: auto;
        display: flex;
        flex-wrap: wrap;
    }

    .image-box img {
        width: 48%;
        margin: 2px;
        border-radius: 4px;
    }
</style>
<div class="container">
    <h1><?php echo e($product->title); ?></h1>
    <?php if($product->images): ?>
    <div class="image-box mb-3">
        <?php $__currentLoopData = json_decode($product->images); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <img src="<?php echo e(asset('storage/images/'.$image)); ?>" class="img-thumbnail" alt="Product Image">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <p><strong>Description:</strong> <?php echo e($product->description); ?></p>
    <p><strong>Price:</strong> $<?php echo e($product->price); ?></p>
    <p><strong>Stock Status:</strong>
        <?php if($product->latestVariant() && $product->latestVariant()->stock_level > 0): ?>
        In Stock
        <?php else: ?>
        Out of Stock
        <?php endif; ?>
    </p>

    <?php if($product->is_on_sale && $product->discount_percentage > 0): ?>
    <?php
    $currentDate = now()->toDateString();
    $isOnSale = $currentDate >= $product->discount_start_date && $currentDate <= $product->discount_end_date;
        ?>
        <?php if($isOnSale): ?>
        <?php
        $discountedPrice = $product->price - ($product->price * ($product->discount_percentage / 100));
        ?>
        <p class="text-danger">Sale Price: $<?php echo e(number_format($discountedPrice, 2)); ?></p>
        <p><strong><?php echo e($product->discount_percentage); ?>% off</strong></p>
        <?php endif; ?>
        <?php endif; ?>

        <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/customer/show.blade.php ENDPATH**/ ?>