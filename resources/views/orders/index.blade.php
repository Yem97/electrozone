@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Orders</h2>

    <form method="GET" action="{{ route('orders.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Tous les statuts --</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>shipped</option>
                </select>
            </div>
        </div>
    </form>

    @if($orders->isEmpty())
        <p class="text-muted">No order found for the current filter.</p>
    @else
        <div class="list-group">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order->id) }}" class="list-group-item list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Order #{{ $order->id }}</strong> ({{ $order->created_at->format('d/m/Y') }})
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'paid' ? 'success' : 'info') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <div><strong>{{ number_format($order->total_price, 2) }}€</strong></div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
