
@extends('layouts.app')

@section('styles')
<style>
    .checkout-container {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .checkout-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .checkout-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .checkout-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .checkout-header h2 {
        position: relative;
        z-index: 2;
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .checkout-step {
        background: white;
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .checkout-step:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1);
    }

    .step-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .step-number {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        margin-right: 1rem;
        font-size: 1.1rem;
    }

    .step-title {
        color: #1e293b;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
    }

    .form-control:hover {
        border-color: #cbd5e1;
        background: white;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
    }

    .error-message i {
        margin-right: 0.5rem;
    }

    .order-summary {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 1rem;
        padding: 2rem;
        position: sticky;
        top: 2rem;
    }

    .summary-header {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .summary-title {
        color: #1e293b;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .order-item {
        display: flex;
        justify-content: between;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .item-quantity {
        color: #64748b;
        font-size: 0.875rem;
    }

    .item-price {
        font-weight: 700;
        color: #059669;
        font-size: 1.1rem;
    }

    .order-total {
        background: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-top: 1rem;
        border: 2px solid #059669;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
    }

    .checkout-btn {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 0.75rem;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        width: 100%;
        margin-top: 2rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4);
    }

    .checkout-btn i {
        margin-right: 0.5rem;
    }

    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .empty-cart h4 {
        color: #1e293b;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }

    .empty-cart p {
        color: #64748b;
        margin-bottom: 2rem;
    }

    .continue-shopping-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 0.75rem;
        padding: 0.875rem 2rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .continue-shopping-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    @media (max-width: 768px) {
        .checkout-container {
            padding: 1rem 0;
        }

        .checkout-step {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .checkout-header {
            padding: 1.5rem;
        }

        .checkout-header h2 {
            font-size: 1.5rem;
        }

        .order-summary {
            position: static;
            margin-top: 2rem;
        }

        .step-header {
            flex-direction: column;
            text-align: center;
        }

        .step-number {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
    }

    .alert {
        border-radius: 0.75rem;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border: none;
        display: flex;
        align-items: center;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-left: 4px solid #059669;
    }

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-left: 4px solid #dc2626;
    }

    .alert i {
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }
</style>
@endsection

@section('content')
<div class="checkout-container">
    <div class="container">
        <div class="checkout-card">
            <div class="checkout-header">
                <h2><i class="bi bi-credit-card me-3"></i>Secure Checkout</h2>
            </div>

            <div class="p-4">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if(count($cart) > 0)
                    <div class="row">
                        <div class="col-lg-8">
                            <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
                                @csrf
                                
                                <!-- Personal Information Step -->
                                <div class="checkout-step">
                                    <div class="step-header">
                                        <div class="step-number">1</div>
                                        <h3 class="step-title">Personal Information</h3>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="full_name" class="form-label">
                                                    <i class="bi bi-person me-2"></i>Full Name *
                                                </label>
                                                <input type="text" 
                                                       name="full_name" 
                                                       id="full_name" 
                                                       class="form-control @error('full_name') is-invalid @enderror" 
                                                       value="{{ old('full_name') }}" 
                                                       placeholder="Enter your full name"
                                                       required>
                                                @error('full_name')
                                                    <div class="error-message">
                                                        <i class="bi bi-exclamation-circle"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">
                                                    <i class="bi bi-envelope me-2"></i>Email Address *
                                                </label>
                                                <input type="email" 
                                                       name="email" 
                                                       id="email" 
                                                       class="form-control @error('email') is-invalid @enderror" 
                                                       value="{{ old('email') }}" 
                                                       placeholder="Enter your email"
                                                       required>
                                                @error('email')
                                                    <div class="error-message">
                                                        <i class="bi bi-exclamation-circle"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone" class="form-label">
                                                    <i class="bi bi-telephone me-2"></i>Phone Number *
                                                </label>
                                                <input type="tel" 
                                                       name="phone" 
                                                       id="phone" 
                                                       class="form-control @error('phone') is-invalid @enderror" 
                                                       value="{{ old('phone') }}" 
                                                       placeholder="Enter your phone number"
                                                       required>
                                                @error('phone')
                                                    <div class="error-message">
                                                        <i class="bi bi-exclamation-circle"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delivery Information Step -->
                                <div class="checkout-step">
                                    <div class="step-header">
                                        <div class="step-number">2</div>
                                        <h3 class="step-title">Delivery Information</h3>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="address" class="form-label">
                                            <i class="bi bi-geo-alt me-2"></i>Delivery Address *
                                        </label>
                                        <textarea name="address" 
                                                  id="address" 
                                                  class="form-control @error('address') is-invalid @enderror" 
                                                  rows="4" 
                                                  placeholder="Enter your complete delivery address including street, city, state, and postal code"
                                                  required>{{ old('address') }}</textarea>
                                        @error('address')
                                            <div class="error-message">
                                                <i class="bi bi-exclamation-circle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="order-summary">
                                <div class="summary-header">
                                    <h3 class="summary-title">
                                        <i class="bi bi-cart-check me-2"></i>Order Summary
                                    </h3>
                                </div>
                                
                                @php $total = 0; @endphp
                                @foreach($cart as $item)
                                    @php $itemTotal = $item['price'] * $item['quantity']; @endphp
                                    @php $total += $itemTotal; @endphp
                                    <div class="order-item">
                                        <div class="item-details">
                                            <div class="item-name">{{ $item['name'] }}</div>
                                            <div class="item-quantity">Quantity: {{ $item['quantity'] }}</div>
                                        </div>
                                        <div class="item-price">${{ number_format($itemTotal, 2) }}</div>
                                    </div>
                                @endforeach
                                
                                <div class="order-total">
                                    <div class="total-row">
                                        <span>Total Amount:</span>
                                        <span class="text-success">${{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                                
                                <button type="submit" form="checkoutForm" class="checkout-btn">
                                    <i class="bi bi-shield-check"></i>
                                    Place Secure Order
                                </button>
                                
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        <i class="bi bi-lock me-1"></i>
                                        Your payment information is secure and encrypted
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-cart">
                        <div class="empty-cart-icon">
                            <i class="bi bi-cart-x"></i>
                        </div>
                        <h4>Your cart is empty!</h4>
                        <p>Please add some items to your cart before proceeding to checkout.</p>
                        <a href="{{ route('shop.index') }}" class="continue-shopping-btn">
                            <i class="bi bi-arrow-left me-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation enhancements
    const form = document.getElementById('checkoutForm');
    const inputs = form.querySelectorAll('input, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
    
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        let errorMessage = '';
        
        // Remove existing error styling
        field.classList.remove('is-invalid');
        const existingError = field.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Validation rules
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        } else if (fieldName === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address.';
            }
        } else if (fieldName === 'phone' && value) {
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            if (!phoneRegex.test(value.replace(/\s/g, ''))) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number.';
            }
        }
        
        if (!isValid) {
            field.classList.add('is-invalid');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = `<i class="bi bi-exclamation-circle"></i> ${errorMessage}`;
            field.parentNode.appendChild(errorDiv);
        }
        
        return isValid;
    }
    
    // Form submission
    form.addEventListener('submit', function(e) {
        let isFormValid = true;
        
        inputs.forEach(input => {
            if (!validateField(input)) {
                isFormValid = false;
            }
        });
        
        if (!isFormValid) {
            e.preventDefault();
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
});
</script>
@endsection
