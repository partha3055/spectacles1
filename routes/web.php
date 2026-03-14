<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WishlistController;
use App\Models\Category;
use App\Models\Brand;

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm']);
    Route::post('/login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout']);
    
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
        
        Route::resource('/categories', App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
        Route::resource('/brands', App\Http\Controllers\Admin\BrandController::class)->except(['show']);
        Route::resource('/products', App\Http\Controllers\Admin\ProductController::class)->except(['show']);
        Route::get('/products/filter', [App\Http\Controllers\Admin\ProductController::class, 'filter']);
        Route::post('/products/{id}/toggle-status', [App\Http\Controllers\Admin\ProductController::class, 'toggleStatus']);
        Route::post('/products/{id}/toggle-sale', [App\Http\Controllers\Admin\ProductController::class, 'toggleSale']);
        
        // Orders
        Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index']);
        Route::get('/orders/{id}', [App\Http\Controllers\Admin\OrderController::class, 'show']);
        Route::post('/orders/{id}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus']);
        Route::post('/orders/{id}/payment', [App\Http\Controllers\Admin\OrderController::class, 'updatePayment']);
        
        // Featured Products
        Route::get('/featured', [App\Http\Controllers\Admin\FeaturedProductController::class, 'index']);
        Route::post('/featured/add', [App\Http\Controllers\Admin\FeaturedProductController::class, 'add']);
        Route::delete('/featured/{id}', [App\Http\Controllers\Admin\FeaturedProductController::class, 'remove']);
        Route::post('/featured/reorder', [App\Http\Controllers\Admin\FeaturedProductController::class, 'reorder']);
    });
});

// Public Routes
Route::get('/', function () {
    return view('index');
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/brands', function () {
    $brands = \App\Models\Brand::with(['products' => function($q) {
        $q->where('is_active', true);
    }])->get();
    return view('brands.index', compact('brands'));
});

Route::get('/brands/{slug}', function ($slug) {
    $brand = Brand::with('products')->where('slug', $slug)->firstOrFail();
    return view('brands.show', compact('brand'));
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/count', [CartController::class, 'count']);
Route::get('/cart/products', [CartController::class, 'getProducts']);
Route::post('/cart/add', [CartController::class, 'add']);
Route::post('/cart/replace', [CartController::class, 'replaceCart']);
Route::post('/cart/remove/{id}', [CartController::class, 'remove']);
Route::post('/cart/update', [CartController::class, 'update']);

Route::get('/checkout', function () {
    $cart = session()->get('cart', []);
    return view('checkout', compact('cart'));
});

Route::post('/checkout', function (\Illuminate\Http\Request $request) {
    try {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Cart is empty']);
        }
        
        // Check or create user account
        $email = $request->email;
        $user = \App\Models\User::where('email', $email)->first();
        
        $accountCreated = false;
        if (!$user) {
            // Create user with password 123456
            $user = \App\Models\User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $email,
                'password' => bcrypt('123456')
            ]);
            $accountCreated = true;
        }
        
        $total = 0;
        $items = [];
        foreach ($cart as $productId => $item) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $price = $product->is_on_sale && $product->sale_price ? $product->sale_price : $product->price;
                $items[] = ['product' => $product, 'quantity' => $item['quantity'], 'price' => $price];
                $total += $price * $item['quantity'];
            }
        }
        
        $billingAddress = $request->same_as_shipping == '1' ? null : $request->billing_address;
        $billingCity = $request->same_as_shipping == '1' ? null : $request->billing_city;
        $billingPincode = $request->same_as_shipping == '1' ? null : $request->billing_pincode;
        
        $orderData = [
            'order_number' => \App\Models\Order::generateOrderNumber(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'billing_address' => $billingAddress,
            'billing_city' => $billingCity,
            'billing_pincode' => $billingPincode,
            'subtotal' => $total,
            'shipping' => 0,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'order_status' => 'confirmed',
        ];
        
        $order = \App\Models\Order::create($orderData);
        
        foreach ($items as $item) {
            $product = $item['product'];
            $orderItemData = [
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_sku' => $product->fnid ?? 'N/A',
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ];
            
            \App\Models\OrderItem::create($orderItemData);
        }
        
        session()->forget('cart');
        session()->forget('cart_pincode');
        
        return response()->json(['success' => true, 'order_id' => $order->order_number, 'account_created' => $accountCreated]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
});

Route::post('/wishlist/toggle', [WishlistController::class, 'toggle']);
Route::get('/wishlist', [WishlistController::class, 'index']);
Route::get('/wishlist/list', [WishlistController::class, 'list']);

// User Auth
Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', [AuthController::class, 'dashboard']);
Route::post('/dashboard/profile', [AuthController::class, 'updateProfile']);
Route::post('/dashboard/password', [AuthController::class, 'updatePassword']);

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/{slug}', function ($slug) {
    $category = Category::where('slug', $slug)->firstOrFail();
    return view('categories.show', compact('category'));
});
