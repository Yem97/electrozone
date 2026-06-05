@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Odered Details #{{ $order->id }}</h2>

    <p><strong>client:</strong> {{ $order->user->name ?? 'unknown user' }}</p>
    <p><strong>delivery address</address>:</strong> {{ $order->shipping_address }}</p>
    <p><strong>Statut:</strong> 
        <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'paid' ? 'success' : 'info') }}">
            {{ ucfirst($order->status) }}
        </span>
    </p>
    <p><strong>Total:</strong> {{ number_format($order->total_price, 2) }} €</p>

    <h4> Ordered Items:</h4>
    <table class="table">
        <thead>
            <tr>
                <th>equipment</th>
                <th>Quantity</th>
                <th>Unite price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>
                        @if($item->equipment && $item->equipment->image)
                            <img src="{{ asset('storage/' . $item->equipment->image) }}" alt="{{ $item->equipment->name }}" style="max-height: 50px; max-width: 50px; margin-right: 10px;">
                        @endif
                        {{ $item->equipment->name ?? 'unknown Item' }}
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} €</td>
                    <td>{{ number_format($item->unit_price * $item->quantity, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('adminorders.index') }}" class="btn btn-secondary">Return</a>
</div>
@endsection
