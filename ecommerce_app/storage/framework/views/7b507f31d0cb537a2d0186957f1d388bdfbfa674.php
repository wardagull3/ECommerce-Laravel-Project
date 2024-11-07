<!-- resources/views/customer/index.blade.php -->


<?php $__env->startSection('content'); ?>
<div class="container">

    <h1>Available Products</h1>
    <form action="<?php echo e(route('customer.search')); ?>" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="query" placeholder="Search by name, category, or keyword">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    <!-- Filters Form -->
    <form action="<?php echo e(route('customer.filter')); ?>" method="GET" class="mb-4">
        <div class="form-row">
            <!-- Category Filter -->
            <div class="col-md-4">
                <select class="form-control" name="category">
                    <option value="">Select Category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Price Filter -->
            <div class="col-md-4">
                <select class="form-control" name="price">
                    <option value="">Select Price Range</option>
                    <option value="1" <?php echo e(request('price') == '1' ? 'selected' : ''); ?>>Under $50</option>
                    <option value="2" <?php echo e(request('price') == '2' ? 'selected' : ''); ?>>$50 - $100</option>
                    <option value="3" <?php echo e(request('price') == '3' ? 'selected' : ''); ?>>$100 - $200</option>
                    <option value="4" <?php echo e(request('price') == '4' ? 'selected' : ''); ?>>$200+</option>
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary mt-4" type="submit">Filter</button>
            </div>
        </div>
    </form>
    <form method="GET" action="<?php echo e(route('customer.sort')); ?>">
        <label for="sort">Sort by Price</label>
        <select name="sort" id="sort">
            <option value="asc" <?php echo e(request('sort') == 'asc' ? 'selected' : ''); ?>>Low to High</option>
            <option value="desc" <?php echo e(request('sort') == 'desc' ? 'selected' : ''); ?>>High to Low</option>
        </select>

        <button type="submit">Sort</button>
    </form>

    <div class="row">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <?php if($product->images): ?>
                <?php $__currentLoopData = json_decode($product->images); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e(asset('storage/images/'.$image)); ?>" width="100" class="mb-2">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title"><?php echo e($product->title); ?></h5>
                    <p class="card-text"><?php echo e($product->description); ?></p>
                    <p class="card-text">Price: $<?php echo e($product->price); ?></p>
                    <p class="card-text">Stock Status: <?php if($product->latestVariant() && $product->latestVariant()->stock_level > 0): ?>
                        In Stock
                        <?php else: ?>
                        Out of Stock
                        <?php endif; ?></p>

                    <?php if($product->is_on_sale && $product->discount_percentage > 0): ?>
                    <?php
                    $currentDate = now()->toDateString();
                    $isOnSale = $currentDate >= $product->discount_start_date && $currentDate <= $product->discount_end_date;
                        ?>
                        <?php if($isOnSale): ?>
                        <?php
                        $discountedPrice = $product->price - ($product->price * ($product->discount_percentage / 100));
                        ?>
                        <p style="color: red;">Sale Price: $<?php echo e(number_format($discountedPrice, 2)); ?></p>
                        <p><strong><?php echo e($product->discount_percentage); ?>% off</strong></p>
                        <?php endif; ?>
                        <?php endif; ?>

                        <!-- Only show the Add to Cart button if the stock status is 'In Stock' -->
                        <?php if($product->latestVariant() && $product->latestVariant()->stock_level > 0): ?>
                        <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                        <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/customer/index.blade.php ENDPATH**/ ?>