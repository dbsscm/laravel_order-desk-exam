@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <h1>Cart</h1>

    <div class="panel">
        @if (empty($lines))
            <p class="empty">Your cart is empty. <a href="{{ route('products.index') }}">Browse products</a> to add items.</p>
        @else
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th class="num">Unit price</th>
                    <th>Quantity</th>
                    <th class="num">Line total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($lines as $line)
                    <tr>
                        <td>
                            {{ $line['product']->name }}<br>
                            <span class="sku">{{ $line['product']->sku }}</span>
                        </td>
                        <td class="num">{{ \App\Support\Money::format($line['product']->price) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $line['product']) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $line['quantity'] }}" aria-label="Quantity">
                                <button type="submit" class="secondary">Update</button>
                            </form>
                        </td>
                        <td class="num">{{ \App\Support\Money::format($line['line_total']) }}</td>
                        <td class="num">
                            <form method="POST" action="{{ route('cart.remove', $line['product']) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <form method="POST" action="{{ route('checkout.store') }}" class="summary">
                @csrf
                @foreach ($lines as $line)
                    <input type="hidden" name="prices[{{ $line['product']->id }}]" value="{{ $line['product']->price }}">
                @endforeach
                <span>Total <strong>{{ \App\Support\Money::format($total) }}</strong></span>
                <button type="submit">Place order</button>
            </form>
        @endif
    </div>
@endsection
