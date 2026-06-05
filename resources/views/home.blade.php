
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-gradient-primary rounded-3 p-4 text-white shadow-lg">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-5 fw-bold mb-2">📊 Dashboard Overview</h1>
                        <p class="lead mb-0 opacity-75">Welcome back! Here's what's happening with your store today.</p>
                    </div>
                    <div class="col-md-4 text-end">
                        <i class="bi bi-graph-up-arrow display-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-people-fill text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 fw-semibold">Total Users</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ number_format($totalUsers) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-tags-fill text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 fw-semibold">Categories</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ number_format($totalEquipmentCategories) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-box-seam-fill text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 fw-semibold">Total Items</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ number_format($totalEquipments) }}</h3>
                            <small class="text-success">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                {{ number_format($totalAvailable) }} Available
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-graph-up text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1 fw-semibold">Growth</h6>
                            <h3 class="mb-0 fw-bold text-dark">+12.5%</h3>
                            <small class="text-muted">vs last month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0 fw-bold">Quick Actions</h5>
                    <p class="text-muted small mb-0">Manage your store efficiently</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                                <i class="bi bi-shop fs-3 mb-2"></i>
                                <span class="fw-semibold">View Shop</span>
                            </a>
                        </div>
                        @can('equipment-list')
                        <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('equipments.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                                <i class="bi bi-box fs-3 mb-2"></i>
                                <span class="fw-semibold">Manage Items</span>
                            </a>
                        </div>
                        @endcan
                        @can('category-list')
                        <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                                <i class="bi bi-tags fs-3 mb-2"></i>
                                <span class="fw-semibold">Categories</span>
                            </a>
                        </div>
                        @endcan
                        <div class="col-sm-6 col-lg-3">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-3 text-decoration-none">
                                <i class="bi bi-cart3 fs-3 mb-2"></i>
                                <span class="fw-semibold">View Cart</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 pb-0">
                    <h5 class="card-title mb-0 fw-bold">System Status</h5>
                    <p class="text-muted small mb-0">Everything is running smoothly</p>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success rounded-circle p-2 me-3">
                            <i class="bi bi-check-lg text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">System Online</h6>
                            <small class="text-muted">All services running</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle p-2 me-3">
                            <i class="bi bi-database text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Database Connected</h6>
                            <small class="text-muted">Response time: 45ms</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded-circle p-2 me-3">
                            <i class="bi bi-shield-check text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">Security Active</h6>
                            <small class="text-muted">Last scan: 2 hours ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hover-lift {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-lift:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card {
    border-radius: 1rem;
}

.btn {
    border-radius: 0.75rem;
    transition: all 0.2s ease-in-out;
}

.btn:hover {
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 2rem;
    }
    
    .display-1 {
        font-size: 3rem;
    }
}
</style>
@endsection
