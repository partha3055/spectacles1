<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Brands - Spectacles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        yellow: {
                            400: '#bbf7d0',
                            500: '#86efac',
                            600: '#4ade80',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <a href="/" class="text-2xl font-bold text-gray-800">
                    <span class="text-yellow-500">Specta</span>cles
                </a>
                <div class="flex items-center gap-6">
                    <a href="/wishlist" class="text-gray-600 hover:text-yellow-500"><i class="fas fa-heart text-xl"></i></a>
                    <a href="/cart" class="text-gray-600 hover:text-yellow-500"><i class="fas fa-shopping-cart text-xl"></i><span class="cart-count ml-1">(0)</span></a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <nav class="text-sm text-gray-500 mb-6">
            <a href="/" class="hover:text-yellow-500">Home</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800">Brands</span>
        </nav>
        
        <h1 class="text-4xl font-bold text-gray-900 mb-8">All Brands</h1>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($brands as $brand)
                <a href="/brands/{{ $brand->slug }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition text-center">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $brand->name }}</h3>
                    <p class="text-sm text-gray-500 mt-2">{{ $brand->products->where('is_active', true)->count() }} Products</p>
                </a>
            @endforeach
        </div>
    </div>
</body>
</html>
