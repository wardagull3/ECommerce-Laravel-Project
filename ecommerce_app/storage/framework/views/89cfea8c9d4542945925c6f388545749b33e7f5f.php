

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
    <h2>Orders</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total Price</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($order->id); ?></td>
                <td><?php echo e($order->user->name); ?></td>
                <td>$<?php echo e($order->total_price); ?></td>
                <td>
                    <form action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <select name="status" onchange="this.form.submit()">
                            <option value="Pending" <?php echo e($order->status === 'Pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="Processing" <?php echo e($order->status === 'Processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="Shipped" <?php echo e($order->status === 'Shipped' ? 'selected' : ''); ?>>Shipped</option>
                            <option value="Delivered" <?php echo e($order->status === 'Delivered' ? 'selected' : ''); ?>>Delivered</option>
                        </select>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>