

<?php $__env->startSection('content'); ?>

<div class="container my-4">
    <h1 class="mt-4 mb-4 text-primary">Product List</h1>

    <div class="mb-5">
        <h2 class="mt-4 mb-3">Bulk Upload Products via CSV</h2>
        <form action="<?php echo e(route('products.bulk-upload')); ?>" method="POST" enctype="multipart/form-data" class="border p-4 rounded bg-light">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="csv_file" class="font-weight-bold">Upload CSV File</label>
                <input type="file" name="csv_file" class="form-control-file" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Upload Products</button>
        </form>
    </div>

    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-success mb-3">Add New Product</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover shadow-sm">
            <thead class="thead-dark">
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
                    <td><?php echo e(Str::limit($product->description, 100)); ?></td>
                    <td>$<?php echo e(number_format($product->price, 2)); ?></td>
                    <td>
                        <?php if($product->latestVariant() && $product->latestVariant()->stock_level > 0): ?>
                        <span class="badge badge-success">In Stock</span>
                        <?php else: ?>
                        <span class="badge badge-danger">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap">
                            <?php if($product->images): ?>
                                <?php $__currentLoopData = json_decode($product->images); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <img src="<?php echo e(asset('storage/images/'.$image)); ?>" alt="Product Image" class="img-thumbnail mr-1 mb-1" style="width: 100px; height: auto;">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-warning btn-sm mb-1">Edit</a>
                        <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm mb-1">Delete</button>
                        </form>
                        <a href="<?php echo e(route('products.variants.create', $product->id)); ?>" class="btn btn-info btn-sm mb-1">Add Variants</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>


<div class="container">

    <div class="d-flex justify-content-center">
        <nav>
            <ul class="pagination">
                <?php if($products->previousPageUrl()): ?>
                    <li class="page-item">
                        <a href="<?php echo e($products->previousPageUrl()); ?>" class="page-link">Previous</a>
                    </li>
                <?php endif; ?>

                <?php if($products->hasMorePages()): ?>
                    <li class="page-item">
                        <a href="<?php echo e($products->nextPageUrl()); ?>" class="page-link">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/products/index.blade.php ENDPATH**/ ?>