@extends('layouts.app')

@section('title', 'My orders')

@section('content')
    <div class="toolbar">
        <h1>My orders</h1>
        <form method="GET" action="{{ route('orders.index') }}" class="inline">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">All</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="secondary">Filter</button>
        </form>
    </div>

    <div class="panel">
        @if ($orders->isEmpty())
            <p class="empty">No orders found.</p>
        @else
            <table>
                <thead>
                <tr>
                    <th>Order</th>
                    <th>Placed</th>
                    <th class="num">Items</th>
                    <th class="num">Total</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('M j, Y g:i A') }}</td>
                        <td class="num">{{ $order->items_count }}</td>
                        <td class="num">{{ \App\Support\Money::format($order->total) }}</td>
                        <td><span class="status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="num"><a href="{{ route('orders.show', $order) }}">View</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
