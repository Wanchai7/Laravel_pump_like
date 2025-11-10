<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'index' => 'required|string',
        ]);

        $cartItem = Cart::where('user_id', Auth::id())
                        ->where('product_id', $request->input('product_id'))
                        ->where('link', $request->input('index'))
                        ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->input('product_id'),
                'quantity' => 1,
                'link' => $request->input('index'),
            ]);
        }

                if ($request->expectsJson()) {
            return response()->json(['success' => 'Product added to cart successfully!']);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->update(['quantity' => $request->quantity]);

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Cart updated successfully!']);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => 'Product removed from cart successfully!']);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => 'Cart cleared successfully!']);
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }

    public function getCartData()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return response()->json([
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }
}
