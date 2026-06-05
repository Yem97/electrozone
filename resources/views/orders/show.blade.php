@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Order #{{ $order->id }}</h2>

    <div class="mb-3">
        <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Statut:</strong> <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'paid' ? 'success' : 'info') }}">{{ ucfirst($order->status) }}</span></p>
        <p><strong>Adresse de livraison:</strong> {{ $order->shipping_address }}</p>
    </div>

    <h4>Ordered item</h4>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>unite price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            @if($item->equipment && $item->equipment->image)
                                <img src="{{ asset('storage/' . $item->equipment->image) }}" alt="Image" width="60" height="60" class="rounded">
                            @else
                                <span class="text-muted">Aucune image</span>
                            @endif
                        </td>
                        <td>{{ $item->equipment->name ?? 'Item deleted' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }}€</td>
                        <td>{{ number_format($item->unit_price * $item->quantity, 2) }}€</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-end mt-3">
        <strong>Total Ordered: {{ number_format($order->total_price, 2) }}€</strong>
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-4">← Back to orders</a>
</div>
@endsection
