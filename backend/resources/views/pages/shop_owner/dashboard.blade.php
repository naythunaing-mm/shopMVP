@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Welcome Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Welcome back, {{ $user->name }}!</h2>
                    <p class="text-muted mb-0">Here's what's happening with your shop today</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('shop-owner.profile.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user me-2"></i>Profile
                    </a>
                    @if($shop)
                        <a href="{{ route('product.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Product
                        </a>
                    @endif
                </div>
            </div>

            @if($shop)
                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="card-body  ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="fw-bold mb-1">{{ $stats['total_products'] ?? 0 }}</h3>
                                        <p class="mb-0 opacity-75">Total Products</p>
                                    </div>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <div class="card-body  ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="fw-bold mb-1">{{ $stats['total_orders'] ?? 0 }}</h3>
                                        <p class="mb-0 opacity-75">Total Orders</p>
                                    </div>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                            <div class="card-body  ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="fw-bold mb-1">{{ $stats['pending_orders'] ?? 0 }}</h3>
                                        <p class="mb-0 opacity-75">Pending Orders</p>
                                    </div>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <div class="card-body  ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h3 class="fw-bold mb-1">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</h3>
                                        <p class="mb-0 opacity-75">Total Revenue</p>
                                    </div>
                                    <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                        <i class="fas fa-dollar-sign fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shop Overview -->
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-store me-2 text-primary"></i>Shop Overview
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        @if($shop && $shop->profile_pic)
                                            <img src="{{ asset($shop->profile_pic) }}" 
                                                 alt="Shop Logo" 
                                                 class="rounded border"
                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('/images/default_logo.png') }}" 
                                                 alt="Shop Logo" 
                                                 class="rounded border"
                                                 style="width: 100px; height: 100px; object-fit: cover;">
                                                 
                                        @endif
                                        
                                    </div>
                                    <div class="col-md-9">
                                        <h4 class="fw-bold text-primary">{{ $shop->name }}</h4>
                                        <p class="text-muted mb-2">{{ $shop->description ?? 'No description provided' }}</p>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $shop->address ?? 'Address not provided' }}
                                                </small>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">
                                                    <i class="fas fa-phone me-1"></i>
                                                    {{ $shop->phone ?? 'Phone not provided' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-tasks me-2 text-success"></i>Quick Actions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('product.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add New Product
                                    </a>
                                    <a href="{{ route('product.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-box me-2"></i>Manage Products
                                    </a>
                                    <a href="{{ route('order.index') }}" class="btn btn-outline-success">
                                        <i class="fas fa-shopping-cart me-2"></i>View Orders
                                    </a>
                                    <a href="{{ route('category.index') }}" class="btn btn-outline-info">
                                        <i class="fas fa-tags me-2"></i>Manage Categories
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Products -->
                <div class="row g-4 mt-2">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-box me-2 text-warning"></i>Recent Products
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($shop->products()->latest()->take(5)->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Added</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($shop->products()->latest()->take(5)->get() as $product)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if($product->pics)
                                                                @php
                                                                    $pics = json_decode($product->pics, true);
                                                                    $firstPic = is_array($pics) && !empty($pics) ? $pics[0] : null;
                                                                @endphp
                                                                @if($firstPic)
                                                                    <img src="{{ asset('storage/' . $firstPic) }}" 
                                                                         alt="{{ $product->name }}" 
                                                                         class="rounded me-2"
                                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                                @else
                                                                    <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                                         style="width: 40px; height: 40px;">
                                                                        <i class="fas fa-image text-muted"></i>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                                     style="width: 40px; height: 40px;">
                                                                    <i class="fas fa-image text-muted"></i>
                                                                </div>
                                                            @endif
                                                            <div>
                                                                <div class="fw-medium">{{ $product->name }}</div>
                                                                <small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                                    </td>
                                                    <td class="fw-medium">${{ number_format($product->price, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($product->status ?? 'active') }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $product->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('product.edit', $product) }}" class="btn btn-outline-primary btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="{{ route('product.show', $product) }}" class="btn btn-outline-info btn-sm">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No Products Yet</h5>
                                        <p class="text-muted">Start by adding your first product to your shop.</p>
                                        <a href="{{ route('product.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add Your First Product
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- No Shop Created -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body py-5">
                                <div class="mb-4">
                                    <i class="fas fa-store fa-4x text-muted"></i>
                                </div>
                                <h3 class="fw-bold text-dark mb-3">Welcome to ShopMVP!</h3>
                                <p class="text-muted mb-4">You haven't set up your shop yet. Create your shop profile to start selling your products online.</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('shop-owner.profile.edit') }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-plus me-2"></i>Create Your Shop
                                    </a>
                                    <a href="{{ route('shop-owner.profile.index') }}" class="btn btn-outline-primary btn-lg">
                                        <i class="fas fa-user me-2"></i>Complete Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-gradient {
    background-size: 200% 200%;
    animation: gradientShift 6s ease infinite;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #6c757d;
    font-size: 0.875rem;
}
</style>
@endsection
