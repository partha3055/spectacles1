<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category']);
        
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }
        
        if ($request->price) {
            if ($request->price == 'low') {
                $query->orderBy('price', 'asc');
            } elseif ($request->price == 'high') {
                $query->orderBy('price', 'desc');
            }
        }
        
        if (!$request->price) {
            $query->orderBy('updated_at', 'desc');
        }
        
        $products = $query->paginate(10);
        
        $categories = Category::whereNotNull('parent_id')->with('parent')->get();
        $brands = Brand::all();
        
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function filter(Request $request)
    {
        $query = Product::with(['brand', 'category']);
        
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->brand) {
            $query->where('brand_id', $request->brand);
        }
        
        if ($request->price) {
            if ($request->price == 'low') {
                $query->orderBy('price', 'asc');
            } elseif ($request->price == 'high') {
                $query->orderBy('price', 'desc');
            }
        }
        
        if (!$request->price) {
            $query->orderBy('updated_at', 'desc');
        }
        
        $products = $query->paginate(10);
        
        return view('admin.products.partials.table', compact('products'))->render();
    }

    public function create()
    {
        $categories = Category::whereNotNull('parent_id')->with('parent')->get();
        $brands = Brand::all();
        return view('admin.products.form', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'is_on_sale' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $data['slug'] = Str::slug($request->name);
        $data['fnid'] = Product::generateFnid();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $data['fnid'] . '.webp';
            $image->move(public_path('uploads/products'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);
        return redirect('/admin/products')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::whereNotNull('parent_id')->with('parent')->get();
        $brands = Brand::all();
        return view('admin.products.form', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'is_on_sale' => 'required|boolean',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('/uploads/products/' . $product->image))) {
                File::delete(public_path('/uploads/products/' . $product->image));
            }
            $image = $request->file('image');
            $imageName = $product->fnid . '.webp';
            $image->move(public_path('uploads/products'), $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);
        return redirect('/admin/products')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
        $product->delete();
        return redirect('/admin/products')->with('success', 'Product deleted successfully');
    }

    public function toggleStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = $request->is_active;
        $product->save();
        
        return response()->json(['success' => true]);
    }

    public function toggleSale(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->is_on_sale = $request->is_on_sale;
        $product->save();
        
        return response()->json(['success' => true]);
    }
}
