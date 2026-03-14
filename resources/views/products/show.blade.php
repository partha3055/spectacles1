<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - Spectacles</title>
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
        <nav class="text-sm text-gray-500 mb-8">
            <a href="/" class="hover:text-yellow-500">Home</a>
            <span class="mx-2">/</span>
            <a href="/products" class="hover:text-yellow-500">Products</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                <!-- Product Image -->
                <div class="relative">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                             class="w-full h-[400px] object-cover rounded-xl">
                    @else
                        <div class="w-full h-[400px] bg-gray-200 rounded-xl flex items-center justify-center">
                            <i class="fas fa-image text-6xl text-gray-400"></i>
                        </div>
                    @endif
                    @if($product->is_on_sale)
                        <span class="absolute top-4 left-4 bg-red-500 text-white px-4 py-1 rounded-full font-semibold">
                            SALE
                        </span>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    @if($product->brand)
                        <p class="text-sm text-gray-500 uppercase tracking-wider">{{ $product->brand->name }}</p>
                    @endif
                    
                    <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $product->name }}</h1>
                    
                    @if($product->category)
                        <p class="text-gray-500 mt-1">{{ $product->category->parent?->name ?? '' }} > {{ $product->category->name }}</p>
                    @endif

                    <div class="mt-4">
                        @if($product->is_on_sale && $product->sale_price)
                            <span class="text-3xl font-bold text-green-600">₹{{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-xl text-gray-400 line-through ml-3">₹{{ number_format($product->price, 2) }}</span>
                            <span class="ml-3 text-green-600 font-semibold">
                                (Save ₹{{ number_format($product->price - $product->sale_price, 2) }})
                            </span>
                            <span class="ml-3 bg-red-100 text-red-600 px-2 py-1 rounded text-sm font-semibold">
                                {{ $product->getDiscountPercentage() }}% OFF
                            </span>
                        @else
                            <span class="text-3xl font-bold text-yellow-600">₹{{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <div class="mt-4 flex items-center gap-4">
                        <span class="text-gray-600">
                            <i class="fas fa-box mr-2"></i>Stock: 
                            @if($product->stock > 0)
                                <span class="text-green-600 font-semibold">{{ $product->stock }} available</span>
                            @else
                                <span class="text-red-600 font-semibold">Out of Stock</span>
                            @endif
                        </span>
                    </div>

                    <!-- Pincode Verification -->
                    <div class="mt-6">
                        <label class="text-gray-700 font-semibold mb-2 block">Check Delivery Availability</label>
                        <div class="flex gap-2">
                            <input type="text" id="pincode" placeholder="Enter PIN code" maxlength="6" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            <button onclick="checkPincode()" 
                                class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg font-semibold hover:bg-yellow-400 transition">
                                Check
                            </button>
                        </div>
                        <p id="pincode-result" class="mt-2 text-sm"></p>
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <div class="mt-8">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button class="px-4 py-2 hover:bg-gray-100" onclick="decreaseQty()">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                    class="w-16 text-center border-none focus:outline-none">
                                <button class="px-4 py-2 hover:bg-gray-100" onclick="increaseQty()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            
                            @if($product->stock > 0)
                                <button type="button" id="addToCartBtn" data-product-id="{{ $product->id }}"
                                    class="flex-1 bg-yellow-500 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition">
                                    <i class="fas fa-shopping-cart mr-2"></i> Add to Cart
                                </button>
                            @else
                                <button disabled 
                                    class="flex-1 bg-gray-300 text-gray-500 px-8 py-3 rounded-lg font-semibold cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif
                            
                            <button class="w-12 h-12 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-100 wishlist-btn" 
                                data-product-id="{{ $product->id }}" onclick="toggleWishlist({{ $product->id }}, this)">
                                <i class="far fa-heart text-xl text-red-500"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <h3 class="font-semibold text-lg mb-3">Description</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $product->description ?? 'No description available.' }}
                        </p>
                    </div>

                    <!-- Features -->
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="fas fa-shipping-fast text-yellow-500"></i>
                            <span class="text-sm">Free Shipping</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="fas fa-undo text-yellow-500"></i>
                            <span class="text-sm">30-Day Returns</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="fas fa-shield-alt text-yellow-500"></i>
                            <span class="text-sm">1 Year Warranty</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="fas fa-headset text-yellow-500"></i>
                            <span class="text-sm">24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
            <div class="flex overflow-x-auto gap-6 pb-4 scrollbar-hide" id="relatedCarousel">
                @foreach($relatedProducts as $related)
                    <a href="/products/{{ $related->slug }}" class="flex-shrink-0 w-[240px] bg-white rounded-xl shadow-sm hover:shadow-lg transition p-4 block relative">
                        <div class="relative overflow-hidden rounded-lg">
                            @if($related->is_on_sale)
                                <span class="absolute top-3 left-3 bg-red-500 text-white text-xs px-2 py-1 rounded z-10">Sale</span>
                            @endif
                            <img src="{{ $related->image ? asset($related->image) : 'https://via.placeholder.com/300x300' }}" 
                                 alt="{{ $related->name }}" class="w-full h-48 object-cover rounded-lg">
                            <div class="product-actions absolute bottom-0 left-0 right-0 bg-white bg-opacity-95 py-3 px-4 flex justify-center gap-3 opacity-0 transform translate-y-4 transition">
                                <button class="w-10 h-10 bg-gray-100 rounded-full hover:bg-red-500 hover:text-white transition wishlist-btn" data-product-id="{{ $related->id }}" onclick="toggleWishlist({{ $related->id }}, this)">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="w-10 h-10 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 transition" onclick="quickAddToCart({{ $related->id }})">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="font-semibold text-gray-800">{{ $related->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $related->brand->name ?? '' }}</p>
                            <div class="mt-2">
                                @if($related->is_on_sale && $related->sale_price)
                                    <span class="text-gray-400 line-through">₹{{ number_format($related->price, 2) }}</span>
                                    <span class="text-yellow-600 font-bold">₹{{ number_format($related->sale_price, 2) }}</span>
                                @else
                                    <span class="text-yellow-600 font-bold">₹{{ number_format($related->price, 2) }}</span>
                                @endif
                            </div>
                            <button onclick="quickAddToCart({{ $related->id }}); event.preventDefault();" class="mt-3 w-full bg-yellow-500 text-gray-900 py-2 rounded-lg font-semibold hover:bg-yellow-600 transition flex items-center justify-center gap-2">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function increaseQty() {
        var input = document.getElementById('quantity');
        var max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decreaseQty() {
        var input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    function checkPincode() {
        var pincode = document.getElementById('pincode').value;
        var result = document.getElementById('pincode-result');
        
        if (pincode.length !== 6) {
            result.innerHTML = '<span class="text-red-500">Please enter a valid 6-digit PIN code</span>';
            return;
        }
        
        var validPincodes = ['700137', '700140'];
        
        if (validPincodes.includes(pincode)) {
            result.innerHTML = '<span class="text-green-600"><i class="fas fa-check-circle mr-1"></i> Delivery available in your area!</span>';
        } else {
            result.innerHTML = '<span class="text-red-500"><i class="fas fa-times-circle mr-1"></i> Sorry, delivery not available in this area</span>';
        }
    }

    function addToCart(productId) {
        var pincode = document.getElementById('pincode').value;
        var validPincodes = ['700137', '700140'];
        
        if (!pincode) {
            showToast('Please enter PIN code first', 'error');
            return;
        }
        
        if (!validPincodes.includes(pincode)) {
            showToast('Delivery not available in this PIN code', 'error');
            return;
        }
        
        var quantity = document.getElementById('quantity').value;
        
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { 
                product_id: productId,
                quantity: quantity,
                pincode: pincode
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = '/cart';
                } else if (response.pincode_mismatch) {
                    if (confirm(response.message)) {
                        replaceCart(productId, quantity, pincode);
                    }
                } else {
                    showToast(response.message || 'Error adding to cart', 'error');
                }
            },
            error: function(xhr) {
                showToast('Error adding to cart: ' + xhr.statusText, 'error');
            }
        });
    }

    function replaceCart(productId, quantity, pincode) {
        $.ajax({
            url: '/cart/replace',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { 
                product_id: productId,
                quantity: quantity,
                pincode: pincode
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = '/cart';
                } else {
                    showToast(response.message || 'Error', 'error');
                }
            }
        });
    }

    function updateCartCount(count) {
        var badges = document.querySelectorAll('.cart-count');
        badges.forEach(function(badge) {
            badge.textContent = '(' + count + ')';
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

    $(document).ready(function() {
        $('#addToCartBtn').click(function() {
            addToCart($(this).data('product-id'));
        });
    });

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

    // Load wishlist on page load
    $(document).ready(function() {
        console.log('Loading wishlist...');
        $.ajax({
            url: '/wishlist/list',
            method: 'GET',
            success: function(response) {
                console.log('Wishlist response:', response);
                if (response.success) {
                    response.wishlists.forEach(function(productId) {
                        console.log('Setting wishlist for product:', productId);
                        var btn = $('.wishlist-btn[data-product-id="' + productId + '"]');
                        btn.find('i').removeClass('far').addClass('fas');
                        btn.addClass('text-red-500');
                    });
                }
            },
            error: function(xhr) {
                console.log('Wishlist error:', xhr);
            }
        });
    });

    // Auto-scroll related products carousel
    (function() {
        const container = document.getElementById('relatedCarousel');
        if (!container) return;
        
        let scrollPos = 0;
        let direction = 1;
        
        function scroll() {
            const maxScroll = container.scrollWidth - container.clientWidth;
            if (maxScroll <= 0) return;
            
            scrollPos += 2 * direction;
            
            if (scrollPos >= maxScroll) {
                direction = -1;
            } else if (scrollPos <= 0) {
                direction = 1;
            }
            
            container.scrollLeft = scrollPos;
        }
        
        let intervalId = setInterval(scroll, 30);
        
        container.addEventListener('mouseenter', () => clearInterval(intervalId));
        container.addEventListener('mouseleave', () => intervalId = setInterval(scroll, 30));
    })();
    </script>
</body>
</html>
