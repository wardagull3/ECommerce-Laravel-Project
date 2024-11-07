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
        <a class="navbar-brand" href="{{ route('products.index') }}">E-Commerce</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.edit') }}">Profile</a> <!-- Link to Profile -->
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" style="text-decoration: none;">Logout</button>
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="min-h-screen bg-gray-100 d-flex">

        <!-- Sidebar -->
        <nav class="bg-light p-3 sidebar">
            <h4>Dashboard</h4>
            <ul class="nav flex-column">
                @auth
                @if(auth()->user()->isAdmin()) <!-- Check if the user is an admin -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">Order Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.lowStock') }}">Notifications</a>
                </li>
                
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.products.index') }}">View Products</a> <!-- Customer view products -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.orders') }}">Order History</a> <!-- Customer view products -->
                </li>
                @endif
                @endauth

            </ul>
        </nav>

        <!-- Main Content Area -->
        <div class="container content">
            @yield('content')
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>