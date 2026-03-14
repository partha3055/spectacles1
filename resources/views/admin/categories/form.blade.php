@extends('admin.layout.main')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h1>
    <a href="/admin/categories" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ isset($category) ? '/admin/categories/'.$category->id : '/admin/categories' }}">
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" value="{{ $category->name ?? '' }}" required 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Parent Category</label>
            <select name="parent_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
                <option value="">None (Main Category)</option>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ isset($category) && $category->parent_id == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" rows="3" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">{{ $category->description ?? '' }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Image</label>
            <input type="file" name="image" accept="image/*"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
            @if(isset($category) && $category->image)
                <div class="mt-3">
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded">
                    <p class="text-sm text-gray-500 mt-1">Current image</p>
                </div>
            @endif
        </div>

        <button type="submit" class="bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg hover:bg-yellow-400 font-bold">
            {{ isset($category) ? 'Update' : 'Create' }} Category
        </button>
    </form>
</div>
@endsection
