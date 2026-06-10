
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient-primary rounded-3 p-4 text-white shadow-lg">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-5 fw-bold mb-2">🛒 Shopping Cart</h1>
                        <p class="lead mb-0 opacity-75">Review your items and proceed to checkout</p>
                    </div>
                    <div class="col-md-4 text-end">
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                {{ count(session('cart')) }} {{ count(session('cart')) === 1 ? 'item' : 'items' }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('cart') && count(session('cart')) > 0)
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="fw-bold mb-0">Cart Items</h5>
                        <small class="text-muted">{{ count(session('cart')) }} {{ count(session('cart')) === 1 ? 'item' : 'items' }} in your cart</small>
                    </div>
                    <div class="card-body p-0">
                        @php $total = 0 @endphp
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <div class="border-bottom p-4 cart-item">
                                <div class="row align-items-center">
                                    <div class="col-md-2 col-3 mb-3 mb-md-0">
                                        @if(isset($details['image']) && $details['image'])
                                            <img src="{{ asset('storage/' . $details['image']) }}" 
                                                 class="img-fluid rounded" 
                                                 alt="{{ $details['name'] }}"
                                                 style="height: 80px; width: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="height: 80px; width: 80px;">
                                                <i class="bi bi-image text-muted fs-3"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4 col-9">
                                        <h6 class="fw-bold mb-1">{{ $details['name'] }}</h6>
                                        <p class="text-muted small mb-2">{{ Str::limit($details['description'] ?? 'No description', 50) }}</p>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ number_format($details['price'], 0) }} FCFA each
                                        </span>
                                    </div>
                                    <div class="col-md-3 col-6 mb-3 mb-md-0">
                                        <div class="input-group input-group-sm">
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ max(1, $details['quantity'] - 1) }}">
                                                <button type="submit" class="btn btn-outline-secondary">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                            </form>
                                            
                                            <input type="text" class="form-control text-center" 
                                                   value="{{ $details['quantity'] }}" readonly>
                                            
                                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $details['quantity'] + 1 }}">
                                                <button type="submit" class="btn btn-outline-secondary">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-4 text-end">
                                        <div class="mb-2">
                                            <strong class="text-success">
                                                {{ number_format($details['price'] * $details['quantity'], 0) }} FCFA
                                            </strong>
                                        </div>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirm('Remove this item from cart?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-1 col-2 text-end">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top">
                    <div class="card-header bg-transparent border-0">
                        <h5 class="fw-bold mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span class="fw-semibold">{{ number_format($total, 0) }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping:</span>
                            <span class="text-success fw-semibold">FREE</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax (VAT):</span>
                            <span class="fw-semibold">{{ number_format($total * 0.15, 0) }} FCFA</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold fs-5">Total:</span>
                            <span class="fw-bold fs-5 text-success">{{ number_format($total + ($total * 0.15), 0) }} FCFA</span>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg">
                                <i class="bi bi-credit-card me-2"></i>
                                Proceed to Checkout
                            </a>
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Continue Shopping
                            </a>
                        </div>

                        <!-- Security Notice -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-shield-check text-success me-2"></i>
                                <small class="text-muted">
                                    <strong>Secure Checkout:</strong><br>
                                    Your payment information is protected with 256-bit SSL encryption.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body py-5">
                        <div class="mb-4">
                            <i class="bi bi-cart-x display-1 text-muted"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Your cart is empty</h3>
                        <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet. Start shopping to fill it up!</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-shop me-2"></i>
                            Start Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #2F9E63 0%, #1B4332 100%);
}

.cart-item {
    transition: background-color 0.2s ease;
}

.cart-item:hover {
    background-color: #f8f9fa;
}

.card {
    border-radius: 1rem;
}

.btn {
    border-radius: 0.5rem;
}

.sticky-top {
    top: 2rem;
}

@media (max-width: 768px) {
    .sticky-top {
        position: relative !important;
        top: auto !important;
    }
    
    .display-5 {
        font-size: 2rem;
    }
}
</style>
@endsection
