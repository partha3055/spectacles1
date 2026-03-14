@extends('admin.layout.main')

@section('content')
<div class="flex items-center justify-between mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Brands</h1>
    <a href="/admin/brands/create" class="bg-yellow-500 text-gray-900 px-4 py-2 rounded-lg hover:bg-yellow-400">
        <i class="fas fa-plus"></i> Add Brand
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Updated</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($brands as $brand)
            <tr>
                <td class="px-6 py-4">{{ $brand->id }}</td>
                <td class="px-6 py-4 font-medium">{{ $brand->name }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $brand->slug }}</td>
                <td class="px-6 py-4 text-gray-500">{{ $brand->products->count() }}</td>
                <td class="px-6 py-4 text-sm text-gray-500">{{ $brand->updated_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</td>
                <td class="px-6 py-4">
                    <a href="/admin/brands/{{ $brand->id }}/edit" class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form method="POST" action="/admin/brands/{{ $brand->id }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $brands->links() }}
</div>
@endsection
