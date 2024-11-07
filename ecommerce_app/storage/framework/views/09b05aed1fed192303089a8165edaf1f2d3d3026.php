<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-Commerce App</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles to make sidebar and content display side by side */
        .sidebar {
            width: 250px;
            /* Fixed width for sidebar */
        }

        .content {
            margin-left: 250px;
            /* Offset for content to the right of sidebar */
        }
    </style>
</head>

<body class="font-sans antialiased">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo e(route('products.index')); ?>">E-Commerce</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <?php if(auth()->guard()->check()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('profile.edit')); ?>">Profile</a> <!-- Link to Profile -->
                </li>
                <li class="nav-item">
                    <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="nav-link btn btn-link" style="text-decoration: none;">Logout</button>
                    </form>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="min-h-screen bg-gray-100 d-flex">

        <!-- Sidebar -->
        <nav class="bg-light p-3 sidebar">
            <h4>Dashboard</h4>
            <ul class="nav flex-column">
                <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isAdmin()): ?> <!-- Check if the user is an admin -->
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('products.index')); ?>">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('categories.index')); ?>">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.orders.index')); ?>">Order Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('admin.lowStock')); ?>">Notifications</a>
                </li>
                
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('customer.products.index')); ?>">View Products</a> <!-- Customer view products -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('customer.orders')); ?>">Order History</a> <!-- Customer view products -->
                </li>
                <?php endif; ?>
                <?php endif; ?>

            </ul>
        </nav>

        <!-- Main Content Area -->
        <div class="container content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html><?php /**PATH C:\laragon\www\ecommerce_app\resources\views/layouts/app.blade.php ENDPATH**/ ?>