@extends('admin.layout.main')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Orders</h1>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order No.</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($orders as $order)
            <tr>
                <td class="px-6 py-4 font-mono font-medium">{{ $order->order_number }}</td>
                <td class="px-6 py-4">
                    <div class="flex -space-x-2">
                        @foreach($order->items->take(3) as $item)
                            @if($item->product && $item->product->image)
                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product_name }}" class="w-10 h-10 rounded-full border-2 border-white object-cover">
                            @endif
                        @endforeach
                        @if($order->items->count() > 3)
                            <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-xs font-medium">
                                +{{ $order->items->count() - 3 }}
                            </div>
                        @endif
                    </div>
                    <span class="text-xs text-gray-500">{{ $order->items->sum('quantity') }} items</span>
                </td>
                <td class="px-6 py-4">
                    {{ $order->first_name }} {{ $order->last_name }}<br>
                    <span class="text-sm text-gray-500">{{ $order->city }}, {{ $order->pincode }}</span>
                </td>
                <td class="px-6 py-4 font-semibold">₹{{ number_format($order->total, 2) }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded 
                        @if($order->payment_status == 'paid') bg-green-100 text-green-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                    <span class="text-xs text-gray-500 block">{{ ucfirst($order->payment_method) }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded 
                        @if($order->order_status == 'delivered') bg-green-100 text-green-800
                        @elseif($order->order_status == 'shipped') bg-blue-100 text-blue-800
                        @elseif($order->order_status == 'confirmed') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}
                </td>
                <td class="px-6 py-4">
                    <a href="/admin/orders/{{ $order->id }}" class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-eye"></i> View
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-gray-500">No orders found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
