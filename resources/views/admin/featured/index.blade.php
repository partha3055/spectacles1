@extends('admin.layout.main')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Featured Products</h1>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Featured Products List -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Featured Products (Homepage)</h2>
        <p class="text-gray-500 text-sm mb-4">Drag and drop to reorder</p>
        
        <ul id="featured-list" class="space-y-2">
            @forelse($products as $product)
                <li class="flex items-center justify-between bg-gray-50 p-3 rounded cursor-move" data-id="{{ $product->id }}">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-grip-lines text-gray-400"></i>
                        <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/40?text=No+Img' }}" 
                             class="w-12 h-12 object-cover rounded">
                        <div>
                            <p class="font-medium">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">
                                @if($product->is_on_sale && $product->sale_price)
                                    <span class="text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</span>
                                    <span class="text-green-600 font-bold">₹{{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    ₹{{ number_format($product->price, 2) }}
                                @endif
                            </p>
                            <p class="text-xs text-gray-400">{{ $product->updated_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    <form method="POST" action="/admin/featured/{{ $product->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </li>
            @empty
                <p class="text-gray-500 text-center py-4">No featured products yet</p>
            @endforelse
        </ul>
        
        @if($products->count() > 0)
            <button id="save-order" class="mt-4 bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg hover:bg-yellow-400 font-bold">
                Save Order
            </button>
        @endif
    </div>

    <!-- Add Products -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Add Products</h2>
        
        <form id="addFeaturedForm" class="mb-4">
            @csrf
            <div class="relative">
                <input type="text" name="product_id" required id="productSelect" list="productList" placeholder="Search and select a product..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:border-yellow-500"
                    autocomplete="off">
                <datalist id="productList">
                    @foreach($allProducts as $product)
                        <option value="{{ $product->name }} - ₹{{ number_format($product->price, 2) }}" data-id="{{ $product->id }}" data-image="{{ $product->image ? asset($product->image) : '' }}">
                    @endforeach
                </datalist>
                <div id="productPreview" class="hidden mt-3 p-3 bg-gray-50 rounded-lg">
                    <img id="previewImage" src="" class="w-20 h-20 object-cover rounded mx-auto">
                </div>
            </div>
            <button type="submit" class="mt-3 w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                <i class="fas fa-plus"></i> Add to Featured
            </button>
        </form>

        <script>
        var products = [
            @foreach($allProducts as $product)
            { id: {{ $product->id }}, name: "{{ $product->name }}", price: {{ $product->price }}, image: "{{ $product->image ? asset($product->image) : '' }}" },
            @endforeach
        ];

        $('#productSelect').on('input', function() {
            var val = $(this).val();
            var product = products.find(p => (p.name + ' - ₹' + p.price.toFixed(2)) === val);
            var preview = $('#productPreview');
            var img = $('#previewImage');
            
            if (product) {
                var imageUrl = product.image || 'https://via.placeholder.com/80?text=No+Image';
                img.attr('src', imageUrl);
                preview.removeClass('hidden');
            } else {
                preview.addClass('hidden');
            }
        });

        $('#addFeaturedForm').on('submit', function(e) {
            e.preventDefault();
            var val = $('#productSelect').val();
            var product = products.find(p => (p.name + ' - ₹' + p.price.toFixed(2)) === val);
            var productId = product ? product.id : null;
            
            if (!productId) {
                showToast('Please select a valid product!', 'error');
                return;
            }
            
            $.ajax({
                url: '/admin/featured/add',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { product_id: productId },
                success: function(response) {
                    showToast('Product added to featured!', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                },
                error: function(xhr) {
                    showToast('Product already in featured!', 'error');
                }
            });
        });
        </script>

        @if($allProducts->count() > 0)
        <div class="mt-6">
            <h3 class="font-bold mb-3">Quick Add (Click to add)</h3>
            <div class="grid grid-cols-2 gap-3">
                @foreach($allProducts as $product)
                    <div class="quick-add-btn cursor-pointer bg-gray-50 hover:bg-gray-100 p-2 rounded text-sm flex items-center gap-2 transition hover:shadow-md" 
                         data-id="{{ $product->id }}">
                        <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/40?text=No+Img' }}" 
                             class="w-10 h-10 object-cover rounded">
                        <div class="overflow-hidden">
                            <p class="truncate font-medium">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">₹{{ number_format($product->sale_price ?? $product->price, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Quick Add - AJAX
    $('.quick-add-btn').on('click', function() {
        var productId = $(this).data('id');
        var btn = $(this);
        
        $.ajax({
            url: '/admin/featured/add',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { product_id: productId },
            success: function(response) {
                // Show success message
                showToast('Product added to featured!', 'success');
                // Reload page after short delay
                setTimeout(function() {
                    location.reload();
                }, 500);
            },
            error: function(xhr) {
                showToast('Product already in featured!', 'error');
            }
        });
    });

    // Drag & Drop
    var list = document.getElementById('featured-list');
    if (list) {
        new Sortable(list, {
            animation: 150,
            handle: '.fa-grip-lines',
            ghostClass: 'bg-yellow-50'
        });

        $('#save-order').on('click', function() {
            var order = [];
            $('#featured-list li').each(function() {
                order.push($(this).data('id'));
            });

            $.ajax({
                url: '/admin/featured/reorder',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { order: order },
                success: function(response) {
                    if (response.success) {
                        showToast('Order saved!', 'success');
                    }
                }
            });
        });
    }

    // Toast notification
    function showToast(message, type) {
        var bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        var toast = $('<div class="fixed top-4 right-4 ' + bgColor + ' text-white px-4 py-3 rounded shadow-lg z-50">' + message + '</div>');
        $('body').append(toast);
        setTimeout(function() {
            toast.fadeOut(function() {
                $(this).remove();
            });
        }, 2000);
    }
});
</script>
@endsection
