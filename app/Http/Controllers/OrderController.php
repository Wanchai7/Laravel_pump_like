<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('welcome')->with('error', 'Your cart is empty.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'รอดำเนินการ',
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'link' => $item->link,
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function adminIndex()
    {
        $orders = Order::with('user', 'items.product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:รอดำเนินการ,ดำเนินการเสร็จเรียบร้อย',
        ]);

        $order->update(['status' => $request->status]);

        $order->user->notify(new OrderStatusUpdated($order));

        return redirect()->route('admin.orders.index')->with('success', 'อัปเดตสถานะคำสั่งซื้อเรียบร้อยแล้ว');
    }

    public function getStatus(Order $order)
    {
        return response()->json(['status' => $order->status]);
    }

    public function destroy(Order $order)
    {
        if (!Auth::user()->hasRole('owner') && !Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'ลบคำสั่งซื้อเรียบร้อยแล้ว');
    }
}
