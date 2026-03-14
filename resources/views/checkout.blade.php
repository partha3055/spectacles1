<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - Spectacles</title>
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
                    <a href="/cart" class="text-gray-600 hover:text-yellow-500"><i class="fas fa-shopping-cart text-xl"></i><span class="cart-count ml-1">({{ count($cart) }})</span></a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>
        
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
        <form method="POST" action="/checkout" id="checkoutForm">
            @csrf
            <input type="hidden" name="same_as_shipping" value="0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="font-semibold text-lg mb-4">Shipping Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">First Name *</label>
                                <input type="text" name="first_name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">Last Name *</label>
                                <input type="text" name="last_name" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-600 text-sm mb-1">Email *</label>
                                <input type="email" name="email" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-600 text-sm mb-1">Phone *</label>
                                <input type="tel" name="phone" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-600 text-sm mb-1">Address *</label>
                                <textarea name="address" required rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">City *</label>
                                <input type="text" name="city" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">PIN Code *</label>
                                <input type="text" name="pincode" required maxlength="6"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="font-semibold text-lg mb-4">Billing Address</h3>
                        <label class="flex items-center mb-4">
                            <input type="checkbox" id="sameAsShipping" onchange="toggleBilling()" class="mr-2">
                            <span class="text-gray-600 text-sm">Same as shipping address</span>
                        </label>
                        <div id="billingFields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-600 text-sm mb-1">Address</label>
                                <textarea name="billing_address" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">City</label>
                                <input type="text" name="billing_city"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm mb-1">PIN Code</label>
                                <input type="text" name="billing_pincode" maxlength="6"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="font-semibold text-lg mb-4">Payment Method</h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="payment_method" value="cod" checked class="mr-3">
                                <i class="fas fa-money-bill-wave text-green-500 mr-3"></i>
                                <span>Cash on Delivery</span>
                            </label>
                            <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 opacity-50">
                                <input type="radio" name="payment_method" value="online" disabled class="mr-3">
                                <i class="fas fa-credit-card text-gray-400 mr-3"></i>
                                <span class="text-gray-400">Online Payment (Coming Soon)</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="font-semibold text-lg mb-4">Order Summary</h3>
                        @foreach($cartItems as $item)
                        <div class="flex gap-3 mb-3 pb-3 border-b">
                            <img src="{{ $item['product']->image ? asset($item['product']->image) : 'https://via.placeholder.com/60' }}" 
                                 alt="{{ $item['product']->name }}" class="w-16 h-16 object-cover rounded">
                            <div class="flex-1">
                                <p class="font-medium text-sm">{{ $item['product']->name }}</p>
                                <p class="text-gray-500 text-sm">Qty: {{ $item['quantity'] }}</p>
                                <p class="font-semibold text-yellow-600">₹{{ number_format($item['subtotal'], 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="border-t pt-4 mt-4">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span>₹{{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Shipping</span>
                                <span class="text-green-600">Free</span>
                            </div>
                            <div class="flex justify-between mb-4">
                                <span class="font-bold text-lg">Total</span>
                                <span class="font-bold text-lg text-yellow-600">₹{{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-yellow-500 text-gray-900 py-3 rounded-lg font-semibold hover:bg-yellow-400 transition mt-4">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
        function toggleBilling() {
            var sameAsShipping = document.getElementById('sameAsShipping').checked;
            var billingFields = document.getElementById('billingFields');
            var sameAsShippingInput = document.querySelector('input[name="same_as_shipping"]');
            if (sameAsShipping) {
                billingFields.classList.add('hidden');
                sameAsShippingInput.value = '1';
            } else {
                billingFields.classList.remove('hidden');
                sameAsShippingInput.value = '0';
            }
        }
        
        $('#checkoutForm').submit(function(e) {
            e.preventDefault();
            
            var pincode = $('input[name="pincode"]').val();
            var validPincodes = ['700137', '700140'];
            
            if (!validPincodes.includes(pincode)) {
                alert('Delivery not available in this PIN code area. We only deliver to 700137 and 700140.');
                return;
            }
            
            // Check if entered PIN is different from cart PIN
            $.ajax({
                url: '/cart/products',
                method: 'GET',
                async: false,
                success: function(cartResponse) {
                    if (cartResponse.pincode && cartResponse.pincode !== pincode && cartResponse.products.length > 0) {
                        var productNames = cartResponse.products.map(function(p) { return p.name + ' (Qty: ' + p.quantity + ')'; }).join(', ');
                        var confirmMsg = 'Your cart has product(s) for PIN: ' + cartResponse.pincode + '\n\nProducts: ' + productNames + '\n\nDo you want to change PIN to ' + pincode + '? Click OK to continue or Cancel to keep ' + cartResponse.pincode;
                        if (!confirm(confirmMsg)) {
                            $('input[name="pincode"]').val(cartResponse.pincode);
                            return;
                        }
                    }
                }
            });
            
            var formData = $(this).serialize();
            console.log('Form data:', formData);
            
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    console.log('Success', response);
                    if (response.success) {
                        var message = 'Order placed successfully! Order ID: ' + response.order_id;
                        if (response.account_created) {
                            message += '\n\nAn account has been created for you with password: 123456\nYou can now login to track your orders.';
                        }
                        alert(message);
                        window.location.href = '/';
                    } else {
                        alert(response.message || 'Error placing order');
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    var msg = 'Error placing order';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg += ': ' + xhr.responseJSON.message;
                    }
                    alert(msg);
                }
            });
        });
    </script>
</body>
</html>
