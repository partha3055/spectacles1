<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Wishlist - Spectacles</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <a href="/" class="text-2xl font-bold text-gray-800">
                    <span class="text-yellow-500">Specta</span>cles
                </a>
                <div class="flex items-center gap-6">
                    <a href="/wishlist" class="text-gray-600 hover:text-yellow-500">
                        <i class="fas fa-heart text-xl"></i>
                    </a>
                    <a href="/cart" class="text-gray-600 hover:text-yellow-500">
                        <i class="fas fa-shopping-cart text-xl"></i><span class="cart-count ml-1">(0)</span>
                    </a>
                    @auth
                        <a href="/dashboard" class="text-gray-600 hover:text-yellow-500">
                            <i class="fas fa-user text-xl"></i>
                        </a>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-red-500">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="/login" class="text-gray-600 hover:text-yellow-500 mr-2">Login</a>
                        <a href="/register" class="text-gray-600 hover:text-yellow-500">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">My Wishlist</h1>
        
        @if($wishlists->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($wishlists as $item)
                    @if($item->product)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <a href="/products/{{ $item->product->slug }}">
                            <img src="{{ $item->product->image ? asset($item->product->image) : 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=300&h=300&fit=crop' }}" 
                                alt="{{ $item->product->name }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4">
                            <a href="/products/{{ $item->product->slug }}" class="font-semibold text-gray-800 hover:text-yellow-600">
                                {{ $item->product->name }}
                            </a>
                            <p class="text-sm text-gray-500">{{ $item->product->brand->name ?? '' }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <div>
                                    @if($item->product->sale_price)
                                        <span class="text-gray-400 line-through">₹{{ number_format($item->product->price, 2) }}</span>
                                        <span class="text-yellow-600 font-bold ml-2">₹{{ number_format($item->product->sale_price, 2) }}</span>
                                    @else
                                        <span class="text-yellow-600 font-bold">₹{{ number_format($item->product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <button onclick="addToCart({{ $item->product->id }})" class="flex-1 bg-yellow-500 text-gray-900 py-2 rounded-lg font-semibold hover:bg-yellow-600 transition text-sm">
                                    <i class="fas fa-shopping-cart mr-1"></i> Add to Cart
                                </button>
                                <button onclick="removeFromWishlist({{ $item->product->id }}, this)" class="px-3 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Your wishlist is empty</p>
                <a href="/" class="inline-block mt-4 bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-600 transition">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function addToCart(productId) {
            $.ajax({
                url: '/cart/add',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { product_id: productId, quantity: 1 },
                success: function(response) {
                    if (response.success) {
                        $('.cart-count').text('(' + response.cart_count + ')');
                        alert('Added to cart!');
                    }
                }
            });
        }

        function removeFromWishlist(productId, btn) {
            $.ajax({
                url: '/wishlist/toggle',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { product_id: productId },
                success: function(response) {
                    if (!response.liked) {
                        $(btn).closest('.bg-white').fadeOut(300, function() {
                            $(this).remove();
                            if ($('.bg-white').length === 0) {
                                location.reload();
                            }
                        });
                    }
                }
            });
        }

        $(document).ready(function() {
            $.ajax({
                url: '/cart/count',
                method: 'GET',
                success: function(response) {
                    $('.cart-count').text('(' + response.count + ')');
                }
            });
        });
    </script>
</body>
</html>
