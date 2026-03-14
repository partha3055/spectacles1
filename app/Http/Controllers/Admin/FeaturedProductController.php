<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

// TODO: Add brand filter in featured products section
class FeaturedProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_featured', true)
            ->orderBy('featured_order', 'asc')
            ->get();
        
        $allProducts = Product::where('is_active', true)
            ->where('is_featured', false)
            ->orderBy('name')
            ->get();
        
        return view('admin.featured.index', compact('products', 'allProducts'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $product->is_featured = true;
        
        $maxOrder = Product::where('is_featured', true)->max('featured_order') ?? 0;
        $product->featured_order = $maxOrder + 1;
        $product->save();

        return back()->with('success', 'Product added to featured list');
    }

    public function remove($id)
    {
        $product = Product::findOrFail($id);
        $product->is_featured = false;
        $product->featured_order = 0;
        $product->save();

        return back()->with('success', 'Product removed from featured list');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order', []);
        
        foreach ($order as $index => $productId) {
            Product::where('id', $productId)->update(['featured_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
