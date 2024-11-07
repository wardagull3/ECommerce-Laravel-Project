

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Order History</h2>

    <?php if($orders->isEmpty()): ?>
        <p>No orders found.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($order->id); ?></td>
                    <td>$<?php echo e($order->total_price); ?></td>
                    <td><?php echo e($order->status); ?></td>
                    <td><?php echo e($order->created_at->format('Y-m-d')); ?></td>
                    <td>
                        <a href="<?php echo e(route('customer.orders.show', $order->id)); ?>" class="btn btn-info">View Details</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/customer/orders/index.blade.php ENDPATH**/ ?>