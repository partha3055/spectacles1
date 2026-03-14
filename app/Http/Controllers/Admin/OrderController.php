<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['order_status' => $request->status]);
        return back()->with('success', 'Order status updated');
    }

    public function updatePayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['payment_status' => $request->status]);
        return back()->with('success', 'Payment status updated');
    }
}
