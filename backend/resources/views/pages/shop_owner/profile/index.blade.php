@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Shop Owner Profile</h2>
                    <p class="text-muted mb-0">Manage your personal and shop information</p>
                </div>
                <a href="{{ route('shop-owner.profile.edit') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-edit me-2"></i>Edit Profile
                </a>
            </div>

            <!-- Profile Cards -->
            <div class="row g-4">
                <!-- Personal Information Card -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary   py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user me-2"></i>Personal Information
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                @if($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image)))
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                         alt="Profile Picture" 
                                         class="rounded-circle border border-3 border-primary"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center   fw-bold mx-auto shadow"
                                         style="width: 120px; height: 120px; font-size: 2.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted">Full Name</label>
                                    <div class="form-control-plaintext bg-light rounded px-3 py-2">
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted">Email Address</label>
                                    <div class="form-control-plaintext bg-light rounded px-3 py-2">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted">Phone Number</label>
                                    <div class="form-control-plaintext bg-light rounded px-3 py-2">
                                        {{ $user->phone ?? 'Not provided' }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-muted">User Code</label>
                                    <div class="form-control-plaintext bg-light rounded px-3 py-2">
                                        <code class="text-primary">{{ $user->user_code }}</code>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shop Information Card -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-success   py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-store me-2"></i>Shop Information
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            @if($shop)
                                <div class="text-center mb-4">
                                    @if($shop->profile_pic && file_exists(storage_path('app/public/' . $shop->profile_pic)))
                                        <img src="{{ asset('storage/' . $shop->profile_pic) }}" 
                                             alt="Shop Logo" 
                                             class="rounded border border-3 border-success"
                                             style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="rounded d-flex align-items-center justify-content-center   fw-bold mx-auto shadow"
                                             style="width: 120px; height: 120px; font-size: 2.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                            <i class="fas fa-store"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-muted">Shop Name</label>
                                        <div class="form-control-plaintext bg-light rounded px-3 py-2">
                                            {{ $shop->name }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-muted">Description</label>
                                        <div class="form-control-plaintext bg-light rounded px-3 py-2" style="min-height: 60px;">
                                            {{ $shop->description ?? 'No description provided' }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-muted">Address</label>
                                        <div class="form-control-plaintext bg-light rounded px-3 py-2">
                                            @if($shop->address || $shop->street)
                                                {{ $shop->street ? $shop->street . ', ' : '' }}
                                                {{ $shop->unit ? $shop->unit . ', ' : '' }}
                                                {{ $shop->address }}
                                                {{ $shop->postal_code ? ' - ' . $shop->postal_code : '' }}
                                            @else
                                                Not provided
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-muted">Shop Phone</label>
                                        <div class="form-control-plaintext bg-light rounded px-3 py-2">
                                            {{ $shop->phone ?? 'Not provided' }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <div class="text-muted mb-3">
                                        <i class="fas fa-store fa-3x"></i>
                                    </div>
                                    <h5 class="text-muted">No Shop Created</h5>
                                    <p class="text-muted mb-3">You haven't set up your shop yet.</p>
                                    <a href="{{ route('shop-owner.profile.edit') }}" class="btn btn-success">
                                        <i class="fas fa-plus me-2"></i>Create Shop
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Row -->
            @if($shop)
            <div class="row g-4 mt-2">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-info   py-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>Quick Statistics
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row text-center">
                                <div class="col-md-3">
                                    <div class="bg-primary bg-opacity-10 rounded p-3">
                                        <i class="fas fa-box fa-2x text-primary mb-2"></i>
                                        <h4 class="fw-bold text-primary">{{ $shop->products()->count() }}</h4>
                                        <p class="text-muted mb-0">Total Products</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bg-success bg-opacity-10 rounded p-3">
                                        <i class="fas fa-shopping-cart fa-2x text-success mb-2"></i>
                                        <h4 class="fw-bold text-success">{{ $shop->orders()->count() }}</h4>
                                        <p class="text-muted mb-0">Total Orders</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bg-warning bg-opacity-10 rounded p-3">
                                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                        <h4 class="fw-bold text-warning">{{ $shop->orders()->where('status', 'pending')->count() }}</h4>
                                        <p class="text-muted mb-0">Pending Orders</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="bg-info bg-opacity-10 rounded p-3">
                                        <i class="fas fa-tags fa-2x text-info mb-2"></i>
                                        <h4 class="fw-bold text-info">{{ $shop->categories()->count() }}</h4>
                                        <p class="text-muted mb-0">Categories</p>
                                    </div>
                                </div>
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
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.form-control-plaintext {
    border: 1px solid #e9ecef !important;
    background-color: #f8f9fa !important;
}

.bg-opacity-10 {
    background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
}
</style>
@endsection
