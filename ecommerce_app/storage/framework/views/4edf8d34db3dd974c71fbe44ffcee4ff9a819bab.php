

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

<h1 class="mt-4 mb-4">Edit Product</h1>

<form action="<?php echo e(route('products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data" class="mb-4">

    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo e($product->title); ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" required><?php echo e($product->description); ?></textarea>
    </div>

    <div class="form-group">
        <label for="price">Price</label>
        <input type="number" name="price" class="form-control" value="<?php echo e($product->price); ?>" required>
    </div>

    <div class="form-group">
        <label for="sku">SKU</label>
        <input type="text" name="sku" class="form-control" value="<?php echo e($product->sku); ?>" required>
    </div>

    <div class="form-group">
        <label for="stock_status">Stock Status</label>

        <select name="stock_status" class="form-control" required>

            <option value="In Stock" <?php echo e($product->stock_status == 'In Stock' ? 'selected' : ''); ?>>In Stock</option>
            <option value="Out of Stock" <?php echo e($product->stock_status == 'Out of Stock' ? 'selected' : ''); ?>>Out of Stock</option>

        </select>

    </div>

    <h3>Existing Images:</h3>

    <?php if($product->images): ?>
        <?php $__currentLoopData = json_decode($product->images); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <img src="<?php echo e(asset('storage/images/'.$image)); ?>" width="100" class="mb-2">
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <div class="form-group">
        <label for="images">Upload New Images (optional)</label>
        <input type="file" name="images[]" class="form-control-file" multiple>
    </div>

    <div class="form-group">
        <label for="categories">Select Categories</label>
        <select name="categories[]" class="form-control" multiple required>
            <?php if($categories && $categories->isNotEmpty()): ?> 
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e($product->categories->contains($category->id) ? 'selected' : ''); ?>><?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <option value="">No categories available</option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="is_on_sale">On Sale</label>
        <input type="checkbox" name="is_on_sale" class="form-control" value= "<?php echo e(isset($product) ?  $product->is_on_sale : ''); ?>">
    </div>

    <div class="form-group">
        <label for="discount_percentage">Discount Percentage (%)</label>
        <input type="number" name="discount_percentage" class="form-control" value="<?php echo e(isset($product) ? $product->discount_percentage : ''); ?>" step="0.01" min="0" max="100">
    </div>

    <div class="form-group">
        <label for="discount_start_date">Discount Start Date</label>
        <input type="date" name="discount_start_date" class="form-control" value="<?php echo e(isset($product) ? $product->discount_start_date : ''); ?>">
    </div>

    <div class="form-group">
        <label for="discount_end_date">Discount End Date</label>
        <input type="date" name="discount_end_date" class="form-control" value="<?php echo e(isset($product) ? $product->discount_end_date : ''); ?>">
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
</form>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/products/edit.blade.php ENDPATH**/ ?>