@extends('layouts.app')

@section('content')
<div class="container">
    <h2> Order list </h2>

    @foreach($orders as $order)
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>Order #{{ $order->id }}</strong><br>
                    Client: {{ $order->user->name ?? 'unknown User' }}
                </div>
                <div class="text-end">
                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'paid' ? 'success' : 'info') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                    <div>{{ number_format($order->total_price, 2) }} €</div>
                    <a href="{{ route('adminorders.show', $order->id) }}" class="btn btn-sm btn-primary mt-2">view details</a>
                </div>
            </div>
            <div class="card-body">
                <ul>
                    @foreach($order->orderItems as $item)
                        <li>
                            {{ $item->equipment->name ?? 'unknown item' }} — 
                            Quantity: {{ $item->quantity }} — 
                            Unit price: {{ number_format($item->unit_price, 2) }} €
                        </li>
                    @endforeach
                </ul>

                {{-- Status update form --}}
                @if(!in_array($order->status, ['shipped', 'cancelled']))
    <form action="{{ route('adminorders.updateStatus', $order->id) }}" method="POST" class="mt-3 d-flex align-items-center">
        @csrf
        @method('PATCH')

        <select name="status" class="form-select me-2" required>
            @if($order->status === 'pending')
                <option value="paid">Mark as paid</option>
                <option value="cancelled">Cancel Oder</option>
            @elseif($order->status === 'paid')
                <option value="shipped">Ship Order</option>
                <option value="cancelled">Cancel Oder</option>
            @endif
        </select>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
@else
    <p class="mt-3 text-muted">Oder {{ $order->status }} — modification not allowed.</p>
@endif

            </div>
        </div>
    @endforeach
</div>
@endsection
