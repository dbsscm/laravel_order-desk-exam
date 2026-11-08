@extends('layouts.app')

@section('title', "Order #{$order->id}")

@section('content')
    <div class="toolbar">
        <h1>Order #{{ $order->id }}</h1>
        @if ($order->isPending())
            <form method="POST" action="{{ route('orders.cancel', $order) }}" class="inline">
                @csrf
                <button type="submit" class="danger">Cancel order</button>
            </form>
        @endif
    </div>
    <p class="meta">
        Placed {{ $order->created_at->format('M j, Y g:i A') }}
        &nbsp;<span class="status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
    </p>

    <div class="panel">
        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th class="num">Unit price</th>
                <th class="num">Quantity</th>
                <th class="num">Line total</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product->name }}<br>
                        <span class="sku">{{ $item->product->sku }}</span>
                    </td>
                    <td class="num">{{ \App\Support\Money::format($item->unit_price) }}</td>
                    <td class="num">{{ $item->quantity }}</td>
                    <td class="num">{{ \App\Support\Money::format($item->lineTotal()) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="summary">
            <span>Total <strong>{{ \App\Support\Money::format($order->total) }}</strong></span>
        </div>
    </div>

    <p><a href="{{ route('orders.index') }}">Back to my orders</a></p>
@endsection
