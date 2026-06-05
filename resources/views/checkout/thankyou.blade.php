
@extends('layouts.app')

@section('styles')
<style>
    .thank-you-container {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .thank-you-card {
        background: white;
        border-radius: 2rem;
        box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.25);
        border: none;
        overflow: hidden;
        transition: all 0.3s ease;
        max-width: 800px;
        margin: 0 auto;
    }

    .thank-you-header {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        padding: 3rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .thank-you-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }

    .success-icon {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
        z-index: 2;
    }

    .success-icon i {
        font-size: 4rem;
        color: white;
        animation: checkmark 0.6s ease-in-out;
    }

    @keyframes checkmark {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .thank-you-title {
        position: relative;
        z-index: 2;
        margin: 0;
        font-size: 3rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        animation: slideInUp 0.8s ease-out;
    }

    .thank-you-subtitle {
        position: relative;
        z-index: 2;
        font-size: 1.25rem;
        opacity: 0.9;
        margin: 0;
        animation: slideInUp 0.8s ease-out 0.2s both;
    }

    @keyframes slideInUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .thank-you-content {
        padding: 3rem 2rem;
    }

    .confirmation-alert {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        border: 2px solid #059669;
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        text-align: center;
        animation: fadeInUp 0.8s ease-out 0.4s both;
    }

    .confirmation-alert h5 {
        color: #047857;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .confirmation-alert h5 i {
        margin-right: 0.5rem;
        font-size: 1.75rem;
    }

    .confirmation-alert p {
        color: #065f46;
        margin: 0;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .info-card {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #e2e8f0;
        animation: fadeInUp 0.8s ease-out 0.6s both;
    }

    .info-card h5 {
        color: #1e293b;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-card h5 i {
        margin-right: 0.5rem;
        color: #667eea;
        font-size: 1.75rem;
    }

    .info-steps {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-step {
        background: white;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        transition: all 0.3s ease;
    }

    .info-step:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1);
    }

    .step-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }

    .step-text {
        color: #1e293b;
        font-weight: 600;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        animation: fadeInUp 0.8s ease-out 0.8s both;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 0.75rem;
        padding: 1rem 2rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        font-size: 1.1rem;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-primary-custom i {
        margin-right: 0.5rem;
        font-size: 1.25rem;
    }

    .contact-info {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #e2e8f0;
        animation: fadeInUp 0.8s ease-out 1s both;
    }

    .contact-info p {
        color: #64748b;
        font-size: 1rem;
        margin: 0;
    }

    .contact-info a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }

    .contact-info a:hover {
        color: #4f46e5;
        text-decoration: underline;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .thank-you-container {
            padding: 1rem 0;
        }

        .thank-you-header {
            padding: 2rem 1rem;
        }

        .thank-you-title {
            font-size: 2rem;
        }

        .thank-you-subtitle {
            font-size: 1rem;
        }

        .success-icon {
            width: 80px;
            height: 80px;
        }

        .success-icon i {
            font-size: 2.5rem;
        }

        .thank-you-content {
            padding: 2rem 1rem;
        }

        .confirmation-alert {
            padding: 1.5rem;
        }

        .info-card {
            padding: 1.5rem;
        }

        .info-steps {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-primary-custom {
            width: 100%;
            justify-content: center;
            max-width: 300px;
        }
    }
</style>
@endsection

@section('content')
<div class="thank-you-container">
    <div class="container">
        <div class="thank-you-card">
            <div class="thank-you-header">
                <div class="success-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h1 class="thank-you-title">Thank You!</h1>
                <p class="thank-you-subtitle">Your order has been placed successfully</p>
            </div>

            <div class="thank-you-content">
                <div class="confirmation-alert">
                    <h5>
                        <i class="bi bi-envelope-check"></i>
                        Order Confirmation
                    </h5>
                    <p>
                        We've sent a confirmation email with your order details and payment instructions. 
                        Please check your email inbox (and spam folder if necessary).
                    </p>
                </div>
                
                <div class="info-card">
                    <h5>
                        <i class="bi bi-clock-history"></i>
                        What happens next?
                    </h5>
                    <div class="info-steps">
                        <div class="info-step">
                            <div class="step-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <p class="step-text">You'll receive an email confirmation</p>
                        </div>
                        <div class="info-step">
                            <div class="step-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <p class="step-text">Complete your payment using the provided instructions</p>
                        </div>
                        <div class="info-step">
                            <div class="step-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <p class="step-text">We'll process and ship your order</p>
                        </div>
                        <div class="info-step">
                            <div class="step-icon">
                                <i class="bi bi-truck"></i>
                            </div>
                            <p class="step-text">Track your package until delivery</p>
                        </div>
                    </div>
                </div>
                
                <div class="action-buttons">
                    @can('order-list')
                    <a href="{{ route('orders.index') }}" class="btn-primary-custom">
                        <i class="bi bi-bag-check"></i>
                        View My Orders
                    </a>
                    @endcan
                    <a href="{{ route('shop.index') }}" class="btn-primary-custom">
                        <i class="bi bi-shop"></i>
                        Continue Shopping
                    </a>
                </div>
                
                <div class="contact-info">
                    <p>
                        Need help? Contact us at 
                        <a href="mailto:support@electrozone.com">support@electrozone.com</a>
                        or call <a href="tel:+1234567890">+237 678 50 9936</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
