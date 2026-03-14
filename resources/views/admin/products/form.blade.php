@extends('admin.layout.main')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h1>
    <a href="/admin/products" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-4xl">
    <form method="POST" action="{{ isset($product) ? '/admin/products/'.$product->id : '/admin/products' }}" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input type="text" name="name" value="{{ $product->name ?? '' }}" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Brand</label>
                <select name="brand_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                    <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ isset($product) && $product->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                <select name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->parent?->name ?? '' }} > {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Stock</label>
                <input type="number" name="stock" value="{{ $product->stock ?? 0 }}" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
        </div>

        <div class="grid grid-cols-4 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Price (₹)</label>
                <input type="number" step="0.01" name="price" value="{{ $product->price ?? '' }}" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Sale Price (₹)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ $product->sale_price ?? '' }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500"
                    placeholder="Optional">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">On Sale</label>
                <select name="is_on_sale" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                    <option value="0" {{ isset($product) && !$product->is_on_sale ? 'selected' : '' }}>No</option>
                    <option value="1" {{ isset($product) && $product->is_on_sale ? 'selected' : '' }}>Yes</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Active</label>
                <select name="is_active" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                    <option value="1" {{ isset($product) && $product->is_active ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ isset($product) && !$product->is_active ? 'selected' : '' }}>No</option>
                </select>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Product Image</label>
            <input type="file" name="image" accept="image/*"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
            @if(isset($product) && $product->image)
                <div class="mt-3">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded">
                    <p class="text-sm text-gray-500 mt-1">Current image</p>
                </div>
            @endif
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" rows="4" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">{{ $product->description ?? '' }}</textarea>
        </div>

        <button type="submit" class="bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg hover:bg-yellow-400 font-bold">
            {{ isset($product) ? 'Update' : 'Create' }} Product
        </button>
    </form>
</div>
@endsection
