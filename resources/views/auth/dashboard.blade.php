<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Account - Spectacles</title>
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
                    <a href="/cart" class="text-gray-600 hover:text-yellow-500"><i class="fas fa-shopping-cart text-xl"></i><span class="cart-count ml-1">(0)</span></a>
                    <a href="/dashboard" class="text-gray-600 hover:text-yellow-500"><i class="fas fa-user text-xl"></i></a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800">My Account</h1>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="text-gray-600 hover:text-red-500">Logout</button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-3xl text-yellow-600"></i>
                        </div>
                        <h3 class="font-semibold text-lg">{{ $user->name }}</h3>
                        <p class="text-gray-500 text-sm">{{ $user->email }}</p>
                    </div>
                    <nav class="space-y-2">
                        <a href="#profile" class="block px-4 py-2 rounded hover:bg-gray-50 text-gray-700" onclick="showTab('profile')">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <a href="#orders" class="block px-4 py-2 rounded hover:bg-gray-50 text-gray-700" onclick="showTab('orders')">
                            <i class="fas fa-shopping-bag mr-2"></i> My Orders
                        </a>
                        <a href="#password" class="block px-4 py-2 rounded hover:bg-gray-50 text-gray-700" onclick="showTab('password')">
                            <i class="fas fa-lock mr-2"></i> Change Password
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Content -->
            <div class="lg:col-span-2">
                <!-- Profile Tab -->
                <div id="profile-tab" class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-6">Edit Profile</h2>
                    <form method="POST" action="/dashboard/profile">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                        </div>
                        <button type="submit" class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-400 transition">
                            Update Profile
                        </button>
                    </form>
                </div>

                <!-- Orders Tab -->
                <div id="orders-tab" class="bg-white rounded-lg shadow p-6 hidden">
                    <h2 class="text-xl font-bold mb-6">My Orders</h2>
                    @if($orders->count() > 0)
                        <div class="space-y-6">
                            @foreach($orders as $order)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <p class="font-semibold">Order #{{ $order->order_number }}</p>
                                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                        <span class="px-3 py-1 text-sm font-medium rounded 
                                            @if($order->order_status == 'delivered') bg-green-500 text-white
                                            @elseif($order->order_status == 'shipped') bg-blue-500 text-white
                                            @elseif($order->order_status == 'confirmed') bg-yellow-500 text-gray-900
                                            @elseif($order->order_status == 'cancelled') bg-red-500 text-white
                                            @else bg-gray-500 text-white @endif">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </div>
                                    
                                    <!-- Delivery Status Timeline -->
                                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                        <p class="text-sm font-medium text-gray-700 mb-3">Delivery Status</p>
                                        @if($order->order_status == 'cancelled')
                                            <div class="text-center py-2">
                                                <span class="inline-flex items-center gap-2 text-red-600 font-medium">
                                                    <i class="fas fa-times-circle"></i> Order Cancelled
                                                </span>
                                            </div>
                                        @else
                                            <div class="flex items-center justify-between relative">
                                                <div class="absolute top-3 left-0 right-0 h-0.5 bg-gray-200"></div>
                                                <div class="absolute top-3 left-0 h-0.5 bg-yellow-500 transition-all" style="width: 
                                                    @if($order->order_status == 'pending') 0%
                                                    @elseif($order->order_status == 'confirmed') 33%
                                                    @elseif($order->order_status == 'shipped') 66%
                                                    @elseif($order->order_status == 'delivered') 100%
                                                    @else 0% @endif"></div>
                                            
                                            @php
                                                $statuses = ['pending' => 'Order Placed', 'confirmed' => 'Confirmed', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
                                                $currentStatus = $order->order_status;
                                                $statusOrder = ['pending', 'confirmed', 'shipped', 'delivered'];
                                                $currentIndex = array_search($currentStatus, $statusOrder);
                                            @endphp
                                            
                                            @foreach($statuses as $status => $label)
                                                <div class="relative flex flex-col items-center z-10">
                                                    <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-medium
                                                        @if($currentStatus == 'cancelled' && $status == $currentStatus)
                                                            bg-red-500 text-white
                                                        @elseif($currentIndex !== false && array_search($status, $statusOrder) <= $currentIndex)
                                                            bg-yellow-500 text-gray-900
                                                        @else
                                                            bg-gray-300 text-gray-500 @endif">
                                                        @if($currentStatus == 'cancelled' && $status == $currentStatus)
                                                            <i class="fas fa-times"></i>
                                                        @elseif($currentIndex !== false && array_search($status, $statusOrder) <= $currentIndex)
                                                            <i class="fas fa-check"></i>
                                                        @else
                                                            <i class="fas fa-circle"></i>
                                                        @endif
                                                    </div>
                                                    <span class="text-xs mt-1 text-gray-600">{{ $label }}</span>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    
                                    <div class="space-y-3 mb-3">
                                        @foreach($order->items as $item)
                                            <div class="flex items-center gap-3 text-sm">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}" class="w-12 h-12 object-cover rounded">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-1">
                                                    <a href="/products/{{ $item->product->slug ?? '' }}" class="text-gray-800 hover:text-yellow-600 font-medium">
                                                        {{ $item->product_name }}
                                                    </a>
                                                    <div class="text-xs text-gray-500">
                                                        <span>Qty: {{ $item->quantity }}</span>
                                                        <span class="mx-1">·</span>
                                                        <span>FNID: {{ $item->product_sku }}</span>
                                                    </div>
                                                </div>
                                                <span class="font-medium">₹{{ number_format($item->subtotal, 2) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-600 border-t pt-3">
                                        <span>{{ $order->items->sum('quantity') }} items</span>
                                        <span>-</span>
                                        <span class="font-semibold text-yellow-600">₹{{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No orders yet.</p>
                    @endif
                </div>

                <!-- Password Tab -->
                <div id="password-tab" class="bg-white rounded-lg shadow p-6 hidden">
                    <h2 class="text-xl font-bold mb-6">Change Password</h2>
                    <form method="POST" action="/dashboard/password">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Current Password</label>
                            <input type="password" name="current_password" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
                            <input type="password" name="password" required minlength="6"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                        </div>
                        <button type="submit" class="bg-yellow-500 text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-400 transition">
                            Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            document.getElementById('profile-tab').classList.add('hidden');
            document.getElementById('orders-tab').classList.add('hidden');
            document.getElementById('password-tab').classList.add('hidden');
            document.getElementById(tab + '-tab').classList.remove('hidden');
        }
    </script>
</body>
</html>
