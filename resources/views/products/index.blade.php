@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1>Products</h1>

    <div class="panel">
        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th class="num">Price</th>
                <th class="num">In stock</th>
                <th>Add to cart</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>
                        {{ $product->name }}<br>
                        <span class="sku">{{ $product->sku }}</span>
                    </td>
                    <td class="num">{{ \App\Support\Money::format($product->price) }}</td>
                    <td class="num">{{ $product->stock }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.add') }}" class="inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $loop->iteration }}">
                            <input type="number" name="quantity" value="1" aria-label="Quantity">
                            <button type="submit">Add to cart</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
