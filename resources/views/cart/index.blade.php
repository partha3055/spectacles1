<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shopping Cart - Spectacles</title>
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
                    <a href="/wishlist" class="text-gray-600 hover:text-yellow-500"><i class="fas fa-heart text-xl"></i></a>
                    <a href="/cart" class="text-gray-600 hover:text-yellow-500"><i class="fas fa-shopping-cart text-xl"></i><span id="cart-count" class="ml-1">({{ count($cart) }})</span></a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>
        
        @php
        $cartItems = [];
        $total = 0;
        
        foreach ($cart as $productId => $item) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $price = $product->is_on_sale && $product->sale_price ? $product->sale_price : $product->price;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'subtotal' => $price * $item['quantity']
                ];
                $total += $price * $item['quantity'];
            }
        }
        @endphp
        
        @if(count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                @foreach($cartItems as $item)
                <div class="bg-white rounded-lg shadow-md p-6 mb-4 flex gap-6">
                    <img src="{{ $item['product']->image ? asset($item['product']->image) : 'https://via.placeholder.com/150' }}" 
                         alt="{{ $item['product']->name }}" class="w-32 h-32 object-cover rounded-lg">
                    <div class="flex-1">
                        <h3 class="font-semibold text-lg">{{ $item['product']->name }}</h3>
                        <p class="text-gray-500">{{ $item['product']->brand->name ?? '' }}</p>
                        <div class="mt-2">
                            @if($item['product']->is_on_sale && $item['product']->sale_price)
                                <span class="text-gray-400 line-through">₹{{ number_format($item['product']->price, 2) }}</span>
                                <span class="text-yellow-600 font-bold ml-2">₹{{ number_format($item['product']->sale_price, 2) }}</span>
                            @else
                                <span class="text-yellow-600 font-bold">₹{{ number_format($item['product']->price, 2) }}</span>
                            @endif
                        </div>
                        <div class="mt-4 flex items-center gap-4">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button class="px-3 py-1 hover:bg-gray-100" onclick="updateQuantity({{ $item['product']->id }}, -1)">-</button>
                                <span class="px-4 py-1">{{ $item['quantity'] }}</span>
                                <button class="px-3 py-1 hover:bg-gray-100" onclick="updateQuantity({{ $item['product']->id }}, 1)">+</button>
                            </div>
                            <button onclick="removeFromCart({{ $item['product']->id }})" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg">₹{{ number_format($item['subtotal'], 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-semibold text-lg mb-4">Order Summary</h3>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal ({{ count($cartItems) }} items)</span>
                        <span class="font-semibold">₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping</span>
                        <span class="text-green-600 font-semibold">Free</span>
                    </div>
                    <hr class="my-4">
                    <div class="flex justify-between mb-4">
                        <span class="font-bold text-lg">Total</span>
                        <span class="font-bold text-lg text-yellow-600">₹{{ number_format($total, 2) }}</span>
                    </div>
                    <button onclick="window.location.href='/checkout'" class="w-full bg-yellow-500 text-gray-900 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-16">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
            <p class="text-xl text-gray-500 mb-4">Your cart is empty</p>
            <a href="/" class="inline-block bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition">
                Continue Shopping
            </a>
        </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateQuantity(productId, change) {
            $.ajax({
                url: '/cart/update',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { 
                    product_id: productId,
                    change: change
                },
                success: function(response) {
                    location.reload();
                }
            });
        }

        function removeFromCart(productId) {
            if (confirm('Remove this item from cart?')) {
                $.ajax({
                    url: '/cart/remove/' + productId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        }

        function checkout() {
            alert('Checkout functionality coming soon!');
        }
    </script>
</body>
</html>
