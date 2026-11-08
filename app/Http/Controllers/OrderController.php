<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Support\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->input('order_status');

        $orders = CurrentUser::get()->orders()
            ->withCount('items')
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        return view('orders.index', [
            'orders' => $orders,
            'statuses' => Order::STATUSES,
            'selectedStatus' => $request->input('status'),
        ]);
    }

    public function show(Order $order): View
    {
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order): RedirectResponse
    {
        if (! $order->isPending()) {
            return back()->withErrors(['order' => 'Only pending orders can be cancelled.']);
        }

        $order->update(['status' => Order::STATUS_CANCELLED]);

        return redirect()->route('orders.show', $order)->with('status', "Order #{$order->id} cancelled.");
    }
}
