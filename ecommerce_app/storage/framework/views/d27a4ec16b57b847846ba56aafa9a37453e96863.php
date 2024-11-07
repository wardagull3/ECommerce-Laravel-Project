

<?php $__env->startSection('content'); ?>

<h1 class="mt-4 mb-4">Product List</h1>
<h2 class="mt-4">Bulk Upload Products via CSV</h2>

<form action="<?php echo e(route('products.bulk-upload')); ?>" method="POST"    enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    <div class="form-group">
        <label for="csv_file"></label>
        <input type="file" name="csv_file" class="form-control" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Upload Products</button>
</form>

<br>
<br>

<a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary mb-3">Add New Product</a>

<table class="table table-striped">

    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock Status</th>
            <th>Images</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($product->title); ?></td>
            <td><?php echo e($product->description); ?></td>
            <td>$<?php echo e($product->price); ?></td>

            <td>
                <?php if($product->latestVariant() && $product->latestVariant()->stock_level > 0): ?>
                In Stock
                <?php else: ?>
                Out of Stock
                <?php endif; ?>
            </td>

            <td>
                <?php if($product->images): ?>
                <?php $__currentLoopData = json_decode($product->images); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e(asset('storage/images/'.$image)); ?>" width="100" class="mb-2">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </td>

            <td>
                <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-warning btn-sm">Edit</a>

                <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>

                <a href="<?php echo e(route('products.variants.create', $product->id)); ?>" class="btn btn-info btn-sm">Add Variants</a>
            </td>

        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>

</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/products/index.blade.php ENDPATH**/ ?>