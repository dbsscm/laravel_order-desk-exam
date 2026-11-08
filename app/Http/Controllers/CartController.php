<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $lines = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $products->get($productId);

            if (! $product) {
                continue;
            }

            $lines[] = [
                'product' => $product,
                'quantity' => $quantity,
                'line_total' => $product->price * $quantity,
            ];

            $total += $product->price;
        }

        return view('cart.index', compact('lines', 'total'));
    }

    public function add(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer'],
        ]);

        $cart = session('cart', []);
        $cart[$data['product_id']] = ($cart[$data['product_id']] ?? 0) + $data['quantity'];
        session(['cart' => $cart]);

        $product = Product::find($data['product_id']);

        return back()->with('status', "{$product->name} added to cart.");
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id] = $data['quantity'];
        }

        return redirect()->route('cart.index')->with('status', 'Quantity updated.');
    }

    public function remove(Product $product): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('status', "{$product->name} removed from cart.");
    }
}
