@extends('admin.layout.main')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Products</h1>
    <a href="/admin/products/create" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg hover:bg-yellow-400">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm text-gray-500 mb-1">Search</label>
            <input type="text" id="search" value="{{ request('search') }}" placeholder="Search product..." 
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500"
                onkeyup="filterProducts()">
        </div>
        <div class="min-w-[150px]">
            <label class="block text-sm text-gray-500 mb-1">Category</label>
            <select id="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" onchange="filterProducts()">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->parent?->name ?? '' }} > {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[150px]">
            <label class="block text-sm text-gray-500 mb-1">Brand</label>
            <select id="brand" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" onchange="filterProducts()">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[120px]">
            <label class="block text-sm text-gray-500 mb-1">Price</label>
            <select id="price" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500" onchange="filterProducts()">
                <option value="">Default</option>
                <option value="low" {{ request('price') == 'low' ? 'selected' : '' }}>Low to High</option>
                <option value="high" {{ request('price') == 'high' ? 'selected' : '' }}>High to Low</option>
            </select>
        </div>
        <div class="flex gap-2">
            <a href="/admin/products" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                <i class="fas fa-times"></i> Reset
            </a>
        </div>
    </div>
</div>

<!-- Results -->
<div id="products-table">
    @include('admin.products.partials.table')
</div>

<script>
var searchTimeout;

function filterProducts() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        var search = $('#search').val();
        var category = $('#category').val();
        var brand = $('#brand').val();
        var price = $('#price').val();
        
        $.ajax({
            url: '/admin/products/filter',
            method: 'GET',
            data: { 
                search: search, 
                category: category, 
                brand: brand,
                price: price 
            },
            success: function(response) {
                $('#products-table').html(response);
            }
        });
    }, 300);
}

$(document).on('click', '.pagination a', function(e) {
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    
    var search = $('#search').val();
    var category = $('#category').val();
    var brand = $('#brand').val();
    var price = $('#price').val();
    
    $.ajax({
        url: '/admin/products/filter?page=' + page,
        method: 'GET',
        data: { 
            search: search, 
            category: category, 
            brand: brand, 
            price: price 
        },
        success: function(response) {
            $('#products-table').html(response);
        }
    });
});

function toggleStatus(productId, checkbox) {
    var isActive = checkbox.checked ? 1 : 0;
    
    $.ajax({
        url: '/admin/products/' + productId + '/toggle-status',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: { is_active: isActive },
        success: function(response) {
            if (response.success) {
                showToast('Status updated successfully!', 'success');
            } else {
                checkbox.checked = !checkbox.checked;
                showToast('Error updating status', 'error');
            }
        },
        error: function() {
            checkbox.checked = !checkbox.checked;
            showToast('Error updating status', 'error');
        }
    });
}

function toggleOnSale(productId, btn) {
    var currentState = btn.classList.contains('bg-red-500');
    var newState = !currentState;
    
    $.ajax({
        url: '/admin/products/' + productId + '/toggle-sale',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: { is_on_sale: newState ? 1 : 0 },
        success: function(response) {
            if (response.success) {
                if (newState) {
                    btn.classList.remove('bg-gray-200', 'text-gray-500');
                    btn.classList.add('bg-red-500', 'text-white', 'hover:bg-red-600');
                    btn.innerHTML = '<i class="fas fa-tag mr-1"></i> SALE';
                } else {
                    btn.classList.remove('bg-red-500', 'text-white', 'hover:bg-red-600');
                    btn.classList.add('bg-gray-200', 'text-gray-500', 'hover:bg-gray-300');
                    btn.innerHTML = '<i class="fas fa-tag mr-1"></i> Sale';
                }
                showToast('Sale status updated!', 'success');
            } else {
                showToast('Error updating sale status', 'error');
            }
        },
        error: function() {
            showToast('Error updating sale status', 'error');
        }
    });
}

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
</script>
@endsection
