<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spectacles - Eye Wear Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }
        .category-card:hover .category-overlay {
            opacity: 1;
        }
        .product-card:hover .product-actions {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Bar -->
    <div class="bg-gray-900 text-white text-sm py-2">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span><i class="fas fa-phone-alt mr-2"></i>+1 234 567 890</span>
                <span><i class="fas fa-envelope mr-2"></i>info@spectacles.com</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-yellow-400">Track Order</a>
                <a href="#" class="hover:text-yellow-400">Store Locator</a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <a href="/" class="text-2xl font-bold text-gray-800">
                    <span class="text-yellow-500">Specta</span>cles
                </a>

                <!-- Search Bar -->
                <div class="flex-1 max-w-xl mx-8">
                    <div class="relative">
                        <input type="text" placeholder="Search for frames, lenses, sunglasses..." 
                            class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-full focus:outline-none focus:border-yellow-500">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Icons -->
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
                        <a href="/login" class="text-gray-600 hover:text-yellow-500 mr-2">
                            Login
                        </a>
                        <a href="/register" class="text-gray-600 hover:text-yellow-500">
                            Register
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex items-center gap-8 pb-4">
                <a href="/" class="text-gray-700 hover:text-yellow-500 font-medium">Home</a>
                @php $categories = \App\Models\Category::whereNull('parent_id')->with('children')->get(); @endphp
                @php $brands = \App\Models\Brand::all(); @endphp
                @foreach($categories as $category)
                    @if($category->children->isEmpty())
                        <a href="/{{ $category->slug }}" class="text-gray-700 hover:text-yellow-500 font-medium">{{ $category->name }}</a>
                    @else
                        <div class="relative group">
                            <a href="/{{ $category->slug }}" class="text-gray-700 hover:text-yellow-500 font-medium cursor-pointer">{{ $category->name }}</a>
                            <div class="absolute left-0 top-full mt-0 bg-white shadow-lg rounded-md py-2 hidden group-hover:block min-w-[180px] z-[100]">
                                @foreach($category->children as $child)
                                    <a href="/{{ $child->slug }}" class="block px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">{{ $child->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="relative group">
                    <a href="/brands" class="text-gray-700 hover:text-yellow-500 font-medium cursor-pointer">Brands</a>
                    <div class="absolute left-0 top-full mt-0 bg-white shadow-lg rounded-md py-2 hidden group-hover:block min-w-[180px] z-[100] max-h-[300px] overflow-y-auto">
                        @foreach($brands as $brand)
                            <a href="/brands/{{ $brand->slug }}" class="block px-4 py-2 text-gray-700 hover:bg-yellow-50 hover:text-yellow-600">{{ $brand->name }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="#" class="text-gray-700 hover:text-yellow-500 font-medium">Sale</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient text-white relative overflow-hidden">
        <div class="container mx-auto px-4 py-20">
            <div class="flex items-center gap-12">
                <div class="flex-1">
                    <span class="text-yellow-400 font-semibold uppercase tracking-wider">New Collection 2026</span>
                    <h1 class="text-5xl font-bold mt-4 mb-6 leading-tight">
                        Find Your Perfect<br>
                        <span class="text-yellow-400">Style</span>
                    </h1>
                    <p class="text-gray-300 text-lg mb-8 max-w-lg">
                        Discover our exclusive range of premium eyewear. From classic designs to modern trends, we have something for everyone.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="bg-yellow-500 text-gray-900 px-8 py-3 rounded-full font-semibold hover:bg-yellow-400 transition">
                            Shop Now
                        </a>
                        <a href="#" class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-gray-900 transition">
                            Book Eye Test
                        </a>
                    </div>
                </div>
                <div class="flex-1 relative">
                    <img src="https://images.unsplash.com/photo-1577803645773-f96470509666?w=600&h=600&fit=crop" 
                        alt="Premium Eyewear" class="w-full max-w-lg mx-auto drop-shadow-2xl">
                </div>
            </div>
        </div>
        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    <!-- Features Bar -->
    <section class="bg-white py-8 border-b">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-4 gap-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-glasses text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Premium Quality</h4>
                        <p class="text-sm text-gray-500">100% authentic</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-shipping-fast text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Free Shipping</h4>
                        <p class="text-sm text-gray-500">On orders above $50</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-undo text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Easy Returns</h4>
                        <p class="text-sm text-gray-500">30-day return policy</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-headset text-yellow-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">24/7 Support</h4>
                        <p class="text-sm text-gray-500">Dedicated support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Shop by Category</h2>
                <p class="text-gray-500 mt-2">Explore our wide range of eyewear</p>
            </div>
            @php 
            $allCategories = \App\Models\Category::whereNotNull('parent_id')->with('parent')->get();
            $categories = $allCategories->groupBy('parent_id');
            @endphp
            <div class="relative">
                <div class="flex overflow-x-auto gap-6 pb-4 scrollbar-hide" id="categoryCarousel">
                    @foreach($allCategories as $category)
                        <a href="/{{ $category->slug }}" class="flex-shrink-0 w-[240px] category-card relative group cursor-pointer overflow-hidden rounded-2xl block">
                            <img src="{{ $category->image ? asset($category->image) : 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=400&h=500&fit=crop' }}" 
                                alt="{{ $category->name }}" class="w-full h-72 object-cover transition transform group-hover:scale-110">
                            <div class="category-overlay absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <div class="text-center text-white">
                                    <h3 class="text-xl font-bold">{{ $category->name }}</h3>
                                    @if($category->parent)
                                        <p class="mt-1 text-sm">{{ $category->parent->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Featured Products</h2>
                <p class="text-gray-500 mt-2">Handpicked for you</p>
            </div>
            
            @php $products = \App\Models\Product::where('is_featured', true)->where('is_active', true)->orderBy('featured_order', 'asc')->take(8)->get(); @endphp
            @if($products->count() == 0)
                @php $products = \App\Models\Product::where('is_active', true)->take(8)->get(); @endphp
            @endif
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($products as $product)
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
                                @if($product->sale_price)
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
                @empty
                    <p class="text-gray-500 col-span-4">No products available</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="py-16 bg-gradient-to-r from-yellow-500 to-yellow-600">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Book Your Eye Test Today</h2>
            <p class="text-white text-lg mb-8 max-w-2xl mx-auto">
                Get a free eye test at any of our 500+ stores. Our expert optometrists will help you find the perfect vision solution.
            </p>
            <a href="#" class="inline-block bg-white text-yellow-600 px-10 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition shadow-lg">
                Book Appointment
            </a>
        </div>
    </section>

    <!-- Brands Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Top Brands</h2>
                <p class="text-gray-500 mt-2">We partner with the world's best eyewear brands</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @php $brands = \App\Models\Brand::all(); @endphp
                @foreach($brands as $brand)
                    <a href="/brands/{{ $brand->slug }}" class="flex items-center justify-center p-6 border rounded-xl hover:shadow-lg transition">
                        <span class="text-xl font-bold text-gray-600">{{ $brand->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-4 gap-8 mb-12">
                <div>
                    <h3 class="text-2xl font-bold mb-6">
                        <span class="text-yellow-500">Specta</span>cles
                    </h3>
                    <p class="text-gray-400 mb-4">Your trusted destination for premium eyewear. We bring you the best brands and quality service.</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-500 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-500 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-500 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-yellow-500 transition">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500">FAQs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500">Store Locator</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-6">Customer Service</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500">Shipping Info</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500">Returns</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500">Order Status</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow-500">Payment Options</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-6">Contact Us</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-2 text-yellow-500"></i>123 Eye Street, Vision City</li>
                        <li><i class="fas fa-phone mr-2 text-yellow-500"></i>+1 234 567 890</li>
                        <li><i class="fas fa-envelope mr-2 text-yellow-500"></i>info@spectacles.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 py-6">
                <div class="flex justify-between items-center">
                    <p class="text-gray-400">&copy; 2026 Spectacles. All rights reserved.</p>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-yellow-500">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-yellow-500">Terms & Conditions</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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
                        showToast('Added to wishlist!', 'success');
                    } else {
                        $(btn).find('i').removeClass('fas').addClass('far');
                        $(btn).removeClass('text-red-500');
                        showToast('Removed from wishlist!', 'success');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        showToast('Please login to add to wishlist', 'error');
                        setTimeout(() => window.location.href = '/login', 1500);
                    } else {
                        showToast('Error updating wishlist', 'error');
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
                        showToast('Added to cart!', 'success');
                    } else if (response.pincode_mismatch) {
                        if (confirm(response.message)) {
                            replaceCart(productId);
                        }
                    } else {
                        showToast(response.message || 'Error adding to cart', 'error');
                    }
                }
            });
        }

        function replaceCart(productId) {
            $.ajax({
                url: '/cart/replace',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { product_id: productId, quantity: 1 },
                success: function(response) {
                    if (response.success) {
                        $('.cart-count').text('(' + response.cart_count + ')');
                        showToast('Added to cart!', 'success');
                    } else {
                        showToast(response.message || 'Error', 'error');
                    }
                }
            });
        }

        function showToast(message, type) {
            var bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            var toast = $('<div class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 ' + bgColor + ' text-white px-6 py-3 rounded shadow-lg z-50">' + message + '</div>');
            $('body').append(toast);
            setTimeout(function() {
                toast.fadeOut(function() {
                    $(this).remove();
                });
            }, 2000);
        }

        function scrollCarousel(direction) {
            const container = document.getElementById('productsCarousel');
            const productCard = container.querySelector('.product-card');
            if (productCard) {
                const cardWidth = productCard.offsetWidth + 24;
                const scrollAmount = cardWidth * 4;
                if (direction === 'left') {
                    container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                } else {
                    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            }
        }

        // Auto-scroll category carousel
        (function() {
            const container = document.getElementById('categoryCarousel');
            let scrollPos = 0;
            let direction = 1;
            let intervalId = null;
            
            function scroll() {
                const maxScroll = container.scrollWidth - container.clientWidth;
                scrollPos += 2 * direction;
                
                if (scrollPos >= maxScroll) {
                    direction = -1;
                } else if (scrollPos <= 0) {
                    direction = 1;
                }
                
                container.scrollLeft = scrollPos;
            }
            
            function start() {
                intervalId = setInterval(scroll, 30);
            }
            
            function stop() {
                clearInterval(intervalId);
            }
            
            start();
            
            container.addEventListener('mouseenter', stop);
            container.addEventListener('mouseleave', start);
        })();
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/cart/count',
                method: 'GET',
                success: function(response) {
                    $('.cart-count').each(function() {
                        $(this).text('(' + response.count + ')');
                    });
                }
            });
            
            // Load wishlist status
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
