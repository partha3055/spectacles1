@extends('admin.layout.main')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">{{ isset($brand) ? 'Edit Brand' : 'Add Brand' }}</h1>
    <a href="/admin/brands" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-2xl">
    <form method="POST" action="{{ isset($brand) ? '/admin/brands/'.$brand->id : '/admin/brands' }}">
        @csrf
        @if(isset($brand))
            @method('PUT')
        @endif

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input type="text" name="name" value="{{ $brand->name ?? '' }}" required 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea name="description" rows="3" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-yellow-500">{{ $brand->description ?? '' }}</textarea>
        </div>

        <button type="submit" class="bg-yellow-500 text-gray-900 px-6 py-3 rounded-lg hover:bg-yellow-400 font-bold">
            {{ isset($brand) ? 'Update' : 'Create' }} Brand
        </button>
    </form>
</div>
@endsection
