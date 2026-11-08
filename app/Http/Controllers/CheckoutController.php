<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Support\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        $prices = $request->input('prices', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $order = DB::transaction(function () use ($cart, $prices, $products) {
            $order = Order::create([
                'user_id' => CurrentUser::get()->id,
                'status' => Order::STATUS_PENDING,
                'total' => 0,
            ]);

            $total = 0;

            foreach ($cart as $productId => $quantity) {
                $product = $products->get($productId);

                if (! $product) {
                    continue;
                }

                $unitPrice = (int) ($prices[$productId] ?? $product->price);

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                ]);

                $product->decrement('stock');

                $total += $unitPrice * $quantity;
            }

            $order->update(['total' => $total]);

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('orders.show', $order)->with('status', "Order #{$order->id} placed.");
    }
}
