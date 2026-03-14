@extends('admin.layout.main')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Order {{ $order->order_number }}</h1>
    <a href="/admin/orders" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4">Order Items</h3>
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Product</th>
                        <th class="text-left py-2">SKU</th>
                        <th class="text-left py-2">Price</th>
                        <th class="text-center py-2">Qty</th>
                        <th class="text-right py-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr class="border-b">
                        <td class="py-3">
                            <div class="flex items-center gap-3">
                                @if($item->product && $item->product->image)
                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}" class="w-12 h-12 object-cover rounded">
                                @endif
                                <span>{{ $item->product_name }}</span>
                            </div>
                        </td>
                        <td class="py-3 font-mono text-sm">{{ $item->product_sku }}</td>
                        <td class="py-3">₹{{ number_format($item->price, 2) }}</td>
                        <td class="py-3 text-center">{{ $item->quantity }}</td>
                        <td class="py-3 text-right font-semibold">₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Shipping Address -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4">Shipping Address</h3>
            <p>{{ $order->first_name }} {{ $order->last_name }}</p>
            <p class="text-gray-600">{{ $order->address }}</p>
            <p class="text-gray-600">{{ $order->city }} - {{ $order->pincode }}</p>
            <p class="text-gray-600">Phone: {{ $order->phone }}</p>
        </div>
        
        <!-- Billing Address -->
        @if($order->billing_address)
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4">Billing Address</h3>
            <p>{{ $order->first_name }} {{ $order->last_name }}</p>
            <p class="text-gray-600">{{ $order->billing_address }}</p>
            <p class="text-gray-600">{{ $order->billing_city }} - {{ $order->billing_pincode }}</p>
        </div>
        @endif
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="font-semibold text-lg mb-4">Order Status</h3>
            <form method="POST" action="/admin/orders/{{ $order->id }}/status" class="mb-4">
                @csrf
                <label class="block text-gray-500 text-sm mb-2">Order Status</label>
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="pending" @if($order->order_status == 'pending') selected @endif>Pending</option>
                    <option value="confirmed" @if($order->order_status == 'confirmed') selected @endif>Confirmed</option>
                    <option value="shipped" @if($order->order_status == 'shipped') selected @endif>Shipped</option>
                    <option value="delivered" @if($order->order_status == 'delivered') selected @endif>Delivered</option>
                    <option value="cancelled" @if($order->order_status == 'cancelled') selected @endif>Cancelled</option>
                </select>
            </form>
            
            <form method="POST" action="/admin/orders/{{ $order->id }}/payment">
                @csrf
                <label class="block text-gray-500 text-sm mb-2">Payment Status</label>
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="pending" @if($order->payment_status == 'pending') selected @endif>Pending</option>
                    <option value="paid" @if($order->payment_status == 'paid') selected @endif>Paid</option>
                    <option value="failed" @if($order->payment_status == 'failed') selected @endif>Failed</option>
                </select>
            </form>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg mb-4">Order Summary</h3>
            <div class="flex justify-between mb-2">
                <span class="text-gray-500">Order Date</span>
                <span>{{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="text-gray-500">Payment Method</span>
                <span class="capitalize">{{ $order->payment_method }}</span>
            </div>
            <hr class="my-4">
            <div class="flex justify-between mb-2">
                <span class="font-semibold">Subtotal</span>
                <span>₹{{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="font-semibold">Shipping</span>
                <span>₹{{ number_format($order->shipping, 2) }}</span>
            </div>
            <hr class="my-4">
            <div class="flex justify-between">
                <span class="font-bold text-lg">Total</span>
                <span class="font-bold text-lg text-yellow-600">₹{{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
