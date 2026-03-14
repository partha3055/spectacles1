<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">FNID</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">On Sale</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Active</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($products as $product)
            <tr>
                <td class="px-4 py-4">{{ $product->id }}</td>
                <td class="px-4 py-4 font-mono text-sm font-bold text-gray-600">{{ $product->fnid }}</td>
                <td class="px-4 py-4">
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded">
                    @else
                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                            <i class="fas fa-image text-gray-400"></i>
                        </div>
                    @endif
                </td>
                <td class="px-4 py-4 font-medium">{{ $product->name }}</td>
                <td class="px-4 py-4 text-gray-500">{{ $product->brand->name ?? '-' }}</td>
                <td class="px-4 py-4">
                    @if($product->is_on_sale && $product->sale_price)
                        <span class="text-gray-400 line-through text-sm">₹{{ number_format($product->price, 2) }}</span>
                        <span class="text-green-600 font-bold block">₹{{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-xs text-red-500">{{ $product->getDiscountPercentage() }}% OFF</span>
                    @else
                        <span class="text-yellow-600 font-bold">₹{{ number_format($product->price, 2) }}</span>
                    @endif
                </td>
                <td class="px-4 py-4">{{ $product->stock }}</td>
                <td class="px-4 py-4 text-center">
                    @if($product->is_on_sale)
                        <button onclick="toggleOnSale({{ $product->id }}, this)" 
                            class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full hover:bg-red-600 transition">
                            <i class="fas fa-tag mr-1"></i> SALE
                        </button>
                    @else
                        <button onclick="toggleOnSale({{ $product->id }}, this)" 
                            class="px-3 py-1 bg-gray-200 text-gray-500 text-xs font-bold rounded-full hover:bg-gray-300 transition">
                            <i class="fas fa-tag mr-1"></i> Sale
                        </button>
                    @endif
                </td>
                <td class="px-4 py-4 text-center">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" 
                            {{ $product->is_active ? 'checked' : '' }}
                            onchange="toggleStatus({{ $product->id }}, this)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                    </label>
                </td>
                <td class="px-4 py-4 text-sm text-gray-500">{{ $product->updated_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</td>
                <td class="px-4 py-4">
                    <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="/admin/products/{{ $product->id }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="px-6 py-8 text-center text-gray-500">No products found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
