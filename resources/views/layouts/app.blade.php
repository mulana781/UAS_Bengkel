<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bengkel Management')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 80px;
            background: linear-gradient(180deg, #8b5cf6 0%, #a855f7 100%);
            border-radius: 0 30px 30px 0;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 0;
        }
        
        .sidebar-icon {
            color: white;
            font-size: 1.5rem;
            margin: 1rem 0;
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .sidebar-icon:hover {
            background: rgba(255,255,255,0.2);
            transform: scale(1.1);
        }
        
        .sidebar-divider {
            width: 40px;
            border: 1px solid rgba(255,255,255,0.3);
            margin: 1rem 0;
        }
        
        .main-content {
            flex: 1;
            background: white;
            border-radius: 30px 0 0 30px;
            padding: 2rem;
            box-shadow: -4px 0 20px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 1.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            border: none;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card.cyan {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        }
        
        .stat-card.purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
        }
        
        .stat-card.orange {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .chart-container {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        
        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
        }
        
        .progress-container {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .progress-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .progress-bar-custom {
            flex: 1;
            height: 12px;
            background: #e5e7eb;
            border-radius: 6px;
            margin-right: 1rem;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 6px;
            transition: width 0.3s ease;
        }
        
        .progress-fill.purple {
            background: linear-gradient(90deg, #8b5cf6 0%, #a855f7 100%);
        }
        
        .progress-fill.orange {
            background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
        }
        
        .progress-percentage {
            font-size: 0.875rem;
            font-weight: 600;
            min-width: 40px;
        }
        
        .pie-chart-container {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .pie-chart {
            width: 64px;
            height: 64px;
            margin-right: 1rem;
        }
        
        .pie-info {
            flex: 1;
        }
        
        .pie-percentage {
            font-size: 1.125rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 0.25rem;
        }
        
        .pie-label {
            font-size: 0.875rem;
            color: #6b7280;
        }
        
        .table-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table-header {
            background: #f8fafc;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .table-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #374151;
            margin: 0;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        
        .status-badge.completed {
            background: #dcfce7;
            color: #166534;
        }
        
        .status-badge.in-progress {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-badge.pending {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .user-info {
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .user-role {
            background: rgba(255,255,255,0.2);
            padding: 0.25rem 0.5rem;
            border-radius: 5px;
            font-size: 0.75rem;
        }
        
        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: 60px;
                border-radius: 0;
                flex-direction: row;
                justify-content: space-around;
                padding: 0 1rem;
            }
            
            .main-content {
                border-radius: 0;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Bengkel Management</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    @auth
                        @if(auth()->user()->hasPermission('manage_customers'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                                <i class="fas fa-users"></i> Customers
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->hasPermission('manage_services'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
                                <i class="fas fa-car"></i> Vehicles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">
                                <i class="fas fa-tools"></i> Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('service-notes.*') ? 'active' : '' }}" href="{{ route('service-notes.index') }}">
                                <i class="fas fa-clipboard-list"></i> Service Notes
                            </a>
                        </li>
                        @endif
                    @endauth
                </ul>
                
                @auth
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ auth()->user()->name }}
                            <span class="user-role">{{ auth()->user()->role->display_name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user-edit"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html> 