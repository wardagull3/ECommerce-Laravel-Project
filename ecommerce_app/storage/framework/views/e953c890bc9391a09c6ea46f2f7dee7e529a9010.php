

<?php $__env->startSection('content'); ?>
<h1 class="mt-4 mb-4">Add New Category</h1>

<form action="<?php echo e(route('categories.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="name">Category Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
    </div>

    <button type="submit" class="btn btn-success">Create Category</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/categories/create.blade.php ENDPATH**/ ?>