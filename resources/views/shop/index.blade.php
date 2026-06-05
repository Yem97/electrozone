@extends('layouts.app')

@section('content')
<div class="container py-4">



    <!-- Hero Section -->
    <div class="bg-image text-white text-center py-5 px-3 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h1 class="fw-bold display-4 mb-3">
                    <i class="bi bi-lightning-fill text-warning me-3"></i>
                    Welcome to ElectroZone
                </h1>
                <p class="lead fs-5 mb-5">Discover premium electronics and hardware with lightning-fast delivery and unbeatable prices.</p>

                <form method="GET" class="row g-3 justify-content-center">
                    <div class="col-lg-4 col-md-6">
                        <select name="category" class="form-select form-select-lg shadow-sm" onchange="this.form.submit()" style="border: none; border-radius: 15px;">
                            <option value="">
                                <i class="bi bi-funnel"></i> All Categories
                            </option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="input-group input-group-lg shadow-sm">
                            <input type="text" name="q" class="form-control" placeholder="Search for products..." value="{{ request('q') }}" style="border: none; border-radius: 15px 0 0 15px;">
                            <button class="btn btn-warning fw-bold px-4" type="submit" style="border-radius: 0 15px 15px 0; border: none;">
                                <i class="bi bi-search me-2"></i>Search
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Quick stats -->
                <div class="row mt-5 text-center">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="bi bi-truck fs-3 me-2"></i>
                        </div>
                        <h6 class="fw-bold">Fast Delivery</h6>
                        <small class="opacity-75">Free shipping on orders over FCFA 500,000</small>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="bi bi-shield-check fs-3 me-2"></i>
                        </div>
                        <h6 class="fw-bold">Secure Payment</h6>
                        <small class="opacity-75">100% secure transactions</small>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center justify-content-center mb-2">
                            <i class="bi bi-headset fs-3 me-2"></i>
                        </div>
                        <h6 class="fw-bold">24/7 Support</h6>
                        <small class="opacity-75">Always here to help</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @section('title',config('app.name'))

<!-- Carousel -->
<div id="categoryCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        @foreach($featuredItems as $index => $item)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="d-flex flex-column align-items-center">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="d-block" style="max-height: 300px; object-fit: contain;" alt="{{ $item->name }}">
                    @endif
                    <div class="text-center mt-3">
                        <h5 class="fw-bold">{{ $item->name }}</h5>
                        <p class="text-muted">{{ Str::limit($item->description, 100) }}</p>
                        <p class="fw-bold text-success">{{ number_format($item->unit_price, 0) }} FCFA</p>
                        <form action="{{ route('cart.add', $item->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button class="btn btn-sm btn-success w-100">🛒 Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
 
 
         
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle p-2"></span>
    </button>
</div>


    <!-- Product Grid -->
    <div class="row">
        @forelse($equipment as $item)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                <div class="card w-100 border-0 shadow-sm hover-shadow position-relative">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top img-fluid" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-semibold text-dark">{{ $item->name }}</h5>
                        <p class="card-text small text-muted">{{ Str::limit($item->description, 60) }}</p>
                        <p class="fw-bold text-success mb-3">{{ number_format($item->unit_price, 2) }} FCFA</p>

                        <form action="{{ route('cart.add', $item->id) }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button class="btn btn-sm btn-success w-100">
                                🛒 Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">😢 No items found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $equipment->onEachSide(1)->links('pagination::bootstrap-5') }}
    </div>

    <!-- Info Section  -->
<div class="bg-dark text-light py-5 px-3 rounded mb-4">
    <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
    <img src="{{ asset('images/logo1.png') }}" alt="ElectroZone" style="height: 40px;" class="me-2">
    <span class="fw-bold fs-5 text-white">Electro<span class="text-primary">Zone</span></span>
               </a><br>
        <div class="row row-cols-1 row-cols-md-4 g-4 text-sm">

            <!-- Static Section 1 -->
            <div class="col">
                <h6 class="fw-bold text-uppercase">Need Help?</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-light text-decoration-none">Chat with us</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Help Center</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Contact Us</a></li>
                </ul>
            </div>

            <!-- Static Section 2 -->
            <div class="col">
                <h6 class="fw-bold text-uppercase">Useful Links</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-light text-decoration-none">Track Order</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Shipping Info</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Return Policy</a></li>
                </ul>
            </div>

            <!-- Static Section 3 -->
            <div class="col">
                <h6 class="fw-bold text-uppercase">Make Money</h6>
                <ul class="list-unstyled small">
                    <li><a href="#" class="text-light text-decoration-none">Become a Vendor</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Affiliate Program</a></li>
                </ul>
            </div>

            <!-- 🔥 Dynamic Categories Column -->
            <div class="col">
                <h6 class="fw-bold text-uppercase">Shop by Category</h6>
                <ul class="list-unstyled small">
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="text-light text-decoration-none">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
</div>
@endsection