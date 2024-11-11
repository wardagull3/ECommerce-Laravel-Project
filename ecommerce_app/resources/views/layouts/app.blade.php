<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-Commerce App</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #007bff;
            color: #fff;
        }

        .navbar-brand,
        .nav-link {
            color: #fff !important;
        }

        .navbar-brand:hover,
        .nav-link:hover {
            color: #f1f1f1 !important;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            color: #adb5bd;
        }

        .sidebar h4 {
            color: #fff;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-height: 100vh;
        }

        .btn-link {
            color: #adb5bd;
        }

        .btn-link:hover {
            color: #495057;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="{{ route('products.index') }}">E-Commerce</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.edit') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link">Logout</button>
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

    <div class="d-flex">

        <nav class="sidebar">
            <h4>Dashboard</h4>
            <ul class="nav flex-column">
                @auth
                @if(auth()->user()->isAdmin())
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
                    <a class="nav-link" href="{{ route('customer.products.index') }}">View Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('customer.orders') }}">Order History</a>
                </li>
                @endif
                @endauth
            </ul>
        </nav>

        <div class="container content">
            @yield('content')
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>