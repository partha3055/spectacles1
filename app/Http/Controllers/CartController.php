<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// TODO: Add full shopping cart functionality (checkout, orders, payment)
class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = count($cart);
        return response()->json(['count' => $count]);
    }

    public function getProducts()
    {
        $cart = session()->get('cart', []);
        $pincode = session()->get('cart_pincode');
        
        $products = [];
        foreach ($cart as $productId => $item) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $products[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $item['quantity']
                ];
            }
        }
        
        return response()->json([
            'products' => $products,
            'pincode' => $pincode,
            'count' => count($cart)
        ]);
    }

    public function add(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        $pincode = $request->pincode ?? null;
        
        $cart = session()->get('cart', []);
        $existingPincode = session()->get('cart_pincode');
        
        // If cart has PIN in session, allow adding without PIN (from home page)
        // But if cart is empty and no PIN sent, that's fine too
        if ($existingPincode && $pincode && $existingPincode !== $pincode) {
            return response()->json([
                'success' => false, 
                'pincode_mismatch' => true,
                'existing_pincode' => $existingPincode,
                'new_pincode' => $pincode,
                'message' => 'Your cart has products for PIN: ' . $existingPincode . '. Do you want to remove them and add from ' . $pincode . '?'
            ]);
        }
        
        // If no PIN in session but PIN provided, save it
        if (!$existingPincode && $pincode) {
            session()->put('cart_pincode', $pincode);
        }
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    public function replaceCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity ?? 1;
        $pincode = $request->pincode ?? null;
        
        // Clear cart and set new PIN
        $cart = [];
        if ($pincode) {
            session()->put('cart_pincode', $pincode);
        }
        
        $cart[$productId] = [
            'quantity' => $quantity
        ];
        
        session()->put('cart', $cart);
        
        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        
        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }

    public function update(Request $request)
    {
        $productId = $request->product_id;
        $change = $request->change ?? 0;
        
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $change;
            
            if ($cart[$productId]['quantity'] <= 0) {
                unset($cart[$productId]);
            }
        }
        
        session()->put('cart', $cart);
        
        return response()->json(['success' => true, 'cart_count' => count($cart)]);
    }
}
