<!doctype html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:300,400,500,600,700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Custom Dropdown Styles and Scripts -->
    <link href="{{ asset('css/custom-dropdown.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap-conflict-fix.js') }}"></script>
    <script src="{{ asset('js/custom-dropdown.js') }}"></script>
    <script src="{{ asset('js/app-initialization.js') }}"></script>
    
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #059669;
            --danger-color: #dc2626;
            --warning-color: #d97706;
            --info-color: #0891b2;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --border-radius: 0.5rem;
            --box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: var(--border-radius);
            margin: 0 0.25rem;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateY(-1px);
        }

        .container-fluid {
            max-width: 1400px;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }

        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .floating-cart {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: 0 8px 25px -5px rgb(0 0 0 / 0.3);
            transition: all 0.3s ease;
        }

        .floating-cart:hover {
            transform: scale(1.1);
            color: white;
            text-decoration: none;
        }

        .floating-cart i {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .navbar-nav {
                background-color: rgba(0, 0, 0, 0.1);
                border-radius: var(--border-radius);
                padding: 1rem;
                margin-top: 1rem;
            }
            
            .floating-cart {
                width: 50px;
                height: 50px;
                bottom: 1rem;
                right: 1rem;
            }
            
            .floating-cart i {
                font-size: 1.25rem;
            }
        }
    </style>
    
    @yield('styles')
</head>

<body>


    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark shadow-lg">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/social/platform.png') }}" alt="ElectroZone" style="height: 45px;" class="me-3">
                    <div>
                        <span class="fw-bold fs-4">Electro<span style="color: #fbbf24;">Zone</span></span>
                       
                    </div>
                </a>
                
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list fs-4"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left side navigation -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        
                    </ul>

                    <!-- Right side navigation -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                         <!-- Cart link for everyone -->
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="{{ route('shop.index') }}">
                                    <i class="bi bi-shop me-2"></i>
                                    Shop
                                </a>
                            </li>
                            <a class="nav-link d-flex align-items-center position-relative" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3 me-2"></i>
                                Cart
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 0.7rem;">
                                    {{ session('cart') ? count(session('cart')) : 0 }}
                                </span>
                            </a>
                        </li>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        {{ __('Login') }}
                                    </a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" href="{{ route('register') }}">
                                            <i class="bi bi-person-plus me-2"></i>
                                            {{ __('Register') }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @else
                            <!-- Admin dropdown menu - only show if user has admin permissions -->
                            @if(auth()->user()->hasAnyPermission(['role-list', 'user-list', 'category-list', 'equipment-list', 'adminorder-list']))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear me-2"></i>
                                    Admin
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @can('equipment-list')
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('equipments.index') }}">
                                        <i class="bi bi-box me-2"></i>Manage Items
                                    </a></li>
                                    @endcan
                                    @can('category-list')
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('categories.index') }}">
                                        <i class="bi bi-tags me-2"></i>Categories
                                    </a></li>
                                    @endcan
                                    @can('adminorder-list')
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('adminorders.index') }}">
                                        <i class="bi bi-clipboard-check me-2"></i>All Orders
                                    </a></li>
                                    @endcan
                                    @if(auth()->user()->hasAnyPermission(['role-list', 'user-list', 'category-list', 'equipment-list', 'adminorder-list']))
                                    <li><hr class="dropdown-divider"></li>
                                    @endif
                                    @can('user-list')
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('users.index') }}">
                                        <i class="bi bi-people me-2"></i>Users
                                    </a></li>
                                    @endcan
                                    @can('role-list')
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('roles.index') }}">
                                        <i class="bi bi-shield-check me-2"></i>Roles
                                    </a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endif

                            <!-- Regular user menu for orders -->
                            @if(!auth()->user()->hasAnyPermission(['role-list', 'user-list', 'category-list', 'equipment-list', 'adminorder-list']) && auth()->user()->can('order-list'))
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center" href="{{ route('orders.index') }}">
                                    <i class="bi bi-bag-check me-2"></i>
                                    My Orders
                                </a>
                            </li>
                            @endif


                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-person-circle me-2"></i>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <h6 class="dropdown-header">Welcome, {{ Auth::user()->name }}!</h6>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-dark py-5 mt-5" style="color: #ffffff !important;">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h5 class="fw-bold mb-3" style="color: #ffffff !important;">ElectroZone</h5>
                        <p style="color: #cccccc !important;">Your trusted partner for quality electronics and hardware. Fast delivery, secure payment, and excellent customer service.</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h6 class="fw-bold mb-3" style="color: #ffffff !important;">Quick Links</h6>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('shop.index') }}" class="text-decoration-none" style="color: #cccccc !important;">Shop</a></li>
                            <li><a href="#" class="text-decoration-none" style="color: #cccccc !important;">About Us</a></li>
                            <li><a href="#" class="text-decoration-none" style="color: #cccccc !important;">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h6 class="fw-bold mb-3" style="color: #ffffff !important;">Support</h6>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-decoration-none" style="color: #cccccc !important;">Help Center</a></li>
                            <li><a href="#" class="text-decoration-none" style="color: #cccccc !important;">Shipping Info</a></li>
                            <li><a href="#" class="text-decoration-none" style="color: #cccccc !important;">Returns</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="my-4" style="border-color: #555555 !important;">
                <div class="text-center" style="color: #cccccc !important;">
                    <p>&copy; {{ date('Y') }} ElectroZone. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <a href="{{ route('cart.index') }}" class="floating-cart" title="View Cart">
        <i class="bi bi-cart3"></i>
        @if(session('cart') && count(session('cart')) > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 0.7rem;">
                {{ count(session('cart')) }}
            </span>
        @endif
    </a>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>