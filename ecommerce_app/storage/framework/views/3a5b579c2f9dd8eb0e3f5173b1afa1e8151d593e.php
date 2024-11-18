

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
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($notification->product->id); ?></td>
            <td><?php echo e($notification->product->title); ?></td>
            <td><?php echo e($notification->stock_level); ?></td>
            <td>
            <a href="<?php echo e(route('products.variants.create', $notification->product->id)); ?>" class="btn btn-info btn-sm">ReStock</a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/admin/notifications.blade.php ENDPATH**/ ?>