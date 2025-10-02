@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>
    <p>Welcome to your dashboard! Customize this page as needed.</p>
</div>
@endsection
<div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Application Dashboard</h1>
            <a href="{{ url('/reports/new') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Generate Report
            </a>
        </div>

        {{-- Summary Statistics Cards (Bootstrap-style) --}}
        <div class="row">

            {{-- Card 1: Total Users --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2 rounded-lg">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Active Users
                                </div>
                                {{-- Example placeholder data. Replace with actual Laravel variables, e.g., {{ $totalUsers }} --}}
                                <div class="h5 mb-0 font-weight-bold text-gray-800">1,250</div>
                            </div>
                            <div class="col-auto">
                                {{-- Placeholder Icon (assuming Font Awesome is available) --}}
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Revenue (Today) --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2 rounded-lg">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Revenue (Today)
                                </div>
                                {{-- Example placeholder data. Replace with actual Laravel variables, e.g., ${{ $dailyRevenue }} --}}
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$$4,215</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Pending Tasks --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2 rounded-lg">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Tasks
                                </div>
                                {{-- Example placeholder data. Replace with actual Laravel variables, e.g., {{ $pendingTasks }} --}}
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Row --}}
        <div class="row">
            
            {{-- Left Column: Activity Feed --}}
            <div class="col-lg-8 mb-4">
                <div class="card shadow mb-4 rounded-lg">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Recent Activity Feed</h6>
                    </div>
                    <div class="card-body">
                        <p>This area is perfect for displaying dynamic content like recent orders, user sign-ups, or system notifications.</p>
                        <ul>
                            <li>User **Jane Doe** signed up 5 minutes ago.</li>
                            <li>New order **#1001** received.</li>
                            <li>System backup completed successfully.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Right Column: Quick Navigation --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow mb-4 rounded-lg">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quick Navigation</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ url('/products') }}" class="btn btn-info btn-block mb-2">Manage Products</a>
                        <a href="{{ url('/orders') }}" class="btn btn-warning btn-block mb-2">Process Orders</a>
                        <a href="{{ url('/users') }}" class="btn btn-secondary btn-block">View All Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>