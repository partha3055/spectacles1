<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Spectacles</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    @if(auth()->guard('admin')->check())
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white min-h-screen fixed">
            <div class="p-6">
                <h1 class="text-2xl font-bold"><span class="text-yellow-500">Specta</span>cles Admin</h1>
            </div>
            <nav class="mt-6">
                <a href="/admin/dashboard" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->is('admin/dashboard') ? 'bg-gray-800 border-l-4 border-yellow-500' : '' }}">
                    <i class="fas fa-home w-6"></i> Dashboard
                </a>
                <a href="/admin/categories" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->is('admin/categories*') ? 'bg-gray-800 border-l-4 border-yellow-500' : '' }}">
                    <i class="fas fa-tags w-6"></i> Categories
                </a>
                <a href="/admin/brands" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->is('admin/brands*') ? 'bg-gray-800 border-l-4 border-yellow-500' : '' }}">
                    <i class="fas fa-star w-6"></i> Brands
                </a>
                <a href="/admin/products" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->is('admin/products*') ? 'bg-gray-800 border-l-4 border-yellow-500' : '' }}">
                    <i class="fas fa-box w-6"></i> Products
                </a>
                <a href="/admin/featured" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->is('admin/featured*') ? 'bg-gray-800 border-l-4 border-yellow-500' : '' }}">
                    <i class="fas fa-star w-6"></i> Featured
                </a>
                <a href="/admin/orders" class="flex items-center px-6 py-3 hover:bg-gray-800 {{ request()->is('admin/orders*') ? 'bg-gray-800 border-l-4 border-yellow-500' : '' }}">
                    <i class="fas fa-shopping-cart w-6"></i> Orders
                </a>
                <form method="POST" action="/admin/logout" class="mt-6">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 hover:bg-gray-800 text-left">
                        <i class="fas fa-sign-out-alt w-6"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8">
            @yield('content')
        </main>
    </div>
    @else
    @yield('content')
    @endif
</body>
</html>
