<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $category->name }} - Spectacles</title>
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
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <nav class="text-sm text-gray-500 mb-6">
            <a href="/" class="hover:text-yellow-500">Home</a>
            <span class="mx-2">/</span>
            @if($category->parent)
                <a href="/{{ $category->parent->slug }}" class="hover:text-yellow-500">{{ $category->parent->name }}</a>
                <span class="mx-2">/</span>
            @endif
            <span class="text-gray-800">{{ $category->name }}</span>
        </nav>

        <h1 class="text-4xl font-bold text-gray-900 mb-8">{{ $category->name }}</h1>
        
        @if($category->children->count() > 0)
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Subcategories</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($category->children as $child)
                        <a href="/{{ $child->slug }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition text-center">
                            <h3 class="text-xl font-semibold text-gray-800">{{ $child->name }}</h3>
                            <p class="text-sm text-gray-500 mt-2">{{ $child->products->count() }} products</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @php $activeProducts = $category->products->where('is_active', true) @endphp
        @if($activeProducts->count() > 0)
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($activeProducts as $product)
                        <a href="/products/{{ $product->slug }}" class="product-card bg-white rounded-xl shadow-sm hover:shadow-lg transition p-4 block">
                            <div class="relative overflow-hidden rounded-lg">
                                <img src="{{ $product->image ? asset($product->image) : 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=300&h=300&fit=crop' }}" 
                                    alt="{{ $product->name }}" class="w-full h-48 object-cover">
                                <div class="product-actions absolute bottom-0 left-0 right-0 bg-white bg-opacity-95 py-3 px-4 flex justify-center gap-3 opacity-0 transform translate-y-4 transition">
                                    <button class="w-10 h-10 bg-gray-100 rounded-full hover:bg-red-500 hover:text-white transition wishlist-btn" data-product-id="{{ $product->id }}" onclick="toggleWishlist({{ $product->id }}, this); event.preventDefault();">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <button class="w-10 h-10 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 transition" onclick="quickAddToCart({{ $product->id }}); event.preventDefault();">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            @if($product->is_on_sale)
                                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-2 py-1 rounded">Sale</span>
                            @endif
                            </div>
                            <div class="mt-4">
                                <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $product->brand->name ?? '' }}</p>
                            <div class="mt-2">
                                @if($product->is_on_sale && $product->sale_price)
                                    <span class="text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</span>
                                    <span class="text-yellow-600 font-bold ml-2">₹{{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="text-yellow-600 font-bold">₹{{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <button onclick="quickAddToCart({{ $product->id }}); event.preventDefault();" class="mt-3 w-full bg-yellow-500 text-gray-900 py-2 rounded-lg font-semibold hover:bg-yellow-600 transition flex items-center justify-center gap-2">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                                </div>
                            </a>
                    @endforeach
                </div>
            </div>
        @elseif($category->children->count() == 0)
            <p class="text-gray-600">No products found in this category.</p>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleWishlist(productId, btn) {
            $.ajax({
                url: '/wishlist/toggle',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { product_id: productId },
                success: function(response) {
                    if (response.liked) {
                        $(btn).find('i').removeClass('far').addClass('fas');
                        $(btn).addClass('text-red-500');
                        alert('Added to wishlist!');
                    } else {
                        $(btn).find('i').removeClass('fas').addClass('far');
                        $(btn).removeClass('text-red-500');
                        alert('Removed from wishlist!');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        alert('Please login to add to wishlist');
                        window.location.href = '/login';
                    } else {
                        alert('Error updating wishlist');
                    }
                }
            });
        }

        function quickAddToCart(productId) {
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

        $(document).ready(function() {
            $.ajax({
                url: '/wishlist/list',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        response.wishlists.forEach(function(productId) {
                            var btn = $('.wishlist-btn[data-product-id="' + productId + '"]');
                            btn.find('i').removeClass('far').addClass('fas');
                            btn.addClass('text-red-500');
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>
