<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to add to wishlist'], 401);
        }
        
        $productId = $request->product_id;
        $userId = Auth::id();
        
        $exists = Wishlist::where('product_id', $productId)->where('user_id', $userId)->first();
        
        if ($exists) {
            $exists->delete();
            return response()->json(['success' => true, 'liked' => false, 'message' => 'Removed from wishlist']);
        } else {
            Wishlist::create(['product_id' => $productId, 'user_id' => $userId]);
            return response()->json(['success' => true, 'liked' => true, 'message' => 'Added to wishlist']);
        }
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $userId = Auth::id();
        $wishlists = Wishlist::where('user_id', $userId)->with('product')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function list()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'wishlists' => []]);
        }
        
        $userId = Auth::id();
        $wishlists = Wishlist::where('user_id', $userId)->pluck('product_id')->toArray();
        return response()->json(['success' => true, 'wishlists' => $wishlists]);
    }
}
