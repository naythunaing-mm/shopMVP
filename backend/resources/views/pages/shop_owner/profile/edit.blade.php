@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Edit Profile</h2>
                    <p class="text-muted mb-0">Update your personal and shop information</p>
                </div>
                <a href="{{ route('shop-owner.profile.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Profile
                </a>
            </div>

            <form action="{{ route('shop-owner.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Personal Information Card -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-primary   py-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user me-2"></i>Personal Information
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <!-- Profile Image -->
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        @if($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image)))
                                            <img id="profilePreview" src="{{ asset('storage/' . $user->profile_image) }}" 
                                                 alt="Profile Picture" 
                                                 class="rounded-circle border-3 border-primary"
                                                 style="width: 120px; height: 120px; object-fit: cover;">
                                        @else
                                            <div id="profilePreview" class="rounded-circle d-flex align-items-center justify-content-center   fw-bold mx-auto shadow"
                                                 style="width: 120px; height: 120px; font-size: 2.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <label for="profile_image" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow cursor-pointer">
                                            <i class="fas fa-camera text-primary"></i>
                                        </label>
                                    </div>
                                    <input type="file" id="profile_image" name="profile_image" class="d-none" accept="image/*">
                                    @error('profile_image')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">Full Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="email" class="form-label fw-semibold">Email Address *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password Change Section -->
                                    <div class="col-12">
                                        <hr class="my-3">
                                        <h6 class="fw-semibold text-muted mb-3">Change Password (Optional)</h6>
                                    </div>

                                    <div class="col-12">
                                        <label for="current_password" class="form-label fw-semibold">Current Password</label>
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                               id="current_password" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password" class="form-label fw-semibold">New Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shop Information Card -->
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-success   py-3">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-store me-2"></i>Shop Information
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <!-- Shop Logo -->
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        @if($shop && $shop->profile_pic && file_exists(storage_path('app/public/' . $shop->profile_pic)))
                                            <img id="shopPreview" src="{{ asset('storage/' . $shop->profile_pic) }}" 
                                                 alt="Shop Logo" 
                                                 class="rounded border-3 border-success"
                                                 style="width: 120px; height: 120px; object-fit: cover;">
                                        @else
                                            <div id="shopPreview" class="bg-success rounded d-flex align-items-center justify-content-center   fw-bold mx-auto"
                                                 style="width: 120px; height: 120px; font-size: 2.5rem;">
                                                <i class="fas fa-store"></i>
                                            </div>
                                        @endif
                                        <label for="shop_profile_pic" class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow cursor-pointer">
                                            <i class="fas fa-camera text-success"></i>
                                        </label>
                                    </div>
                                    <input type="file" id="shop_profile_pic" name="shop_profile_pic" class="d-none" accept="image/*">
                                    @error('shop_profile_pic')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="shop_name" class="form-label fw-semibold">Shop Name</label>
                                        <input type="text" class="form-control @error('shop_name') is-invalid @enderror" 
                                               id="shop_name" name="shop_name" value="{{ old('shop_name', $shop->name ?? '') }}">
                                        @error('shop_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="shop_description" class="form-label fw-semibold">Shop Description</label>
                                        <textarea class="form-control @error('shop_description') is-invalid @enderror" 
                                                  id="shop_description" name="shop_description" rows="3">{{ old('shop_description', $shop->description ?? '') }}</textarea>
                                        @error('shop_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="shop_street" class="form-label fw-semibold">Street Address</label>
                                        <input type="text" class="form-control @error('shop_street') is-invalid @enderror" 
                                               id="shop_street" name="shop_street" value="{{ old('shop_street', $shop->street ?? '') }}">
                                        @error('shop_street')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="shop_unit" class="form-label fw-semibold">Unit/Suite</label>
                                        <input type="text" class="form-control @error('shop_unit') is-invalid @enderror" 
                                               id="shop_unit" name="shop_unit" value="{{ old('shop_unit', $shop->unit ?? '') }}">
                                        @error('shop_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="shop_postal_code" class="form-label fw-semibold">Postal Code</label>
                                        <input type="text" class="form-control @error('shop_postal_code') is-invalid @enderror" 
                                               id="shop_postal_code" name="shop_postal_code" value="{{ old('shop_postal_code', $shop->postal_code ?? '') }}">
                                        @error('shop_postal_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="shop_address" class="form-label fw-semibold">City/Area</label>
                                        <input type="text" class="form-control @error('shop_address') is-invalid @enderror" 
                                               id="shop_address" name="shop_address" value="{{ old('shop_address', $shop->address ?? '') }}">
                                        @error('shop_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="shop_phone" class="form-label fw-semibold">Shop Phone</label>
                                        <input type="text" class="form-control @error('shop_phone') is-invalid @enderror" 
                                               id="shop_phone" name="shop_phone" value="{{ old('shop_phone', $shop->phone ?? '') }}">
                                        @error('shop_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="shop_social_links" class="form-label fw-semibold">Social Media Links</label>
                                        <textarea class="form-control @error('shop_social_links') is-invalid @enderror" 
                                                  id="shop_social_links" name="shop_social_links" rows="2" 
                                                  placeholder="Facebook, Instagram, Twitter links...">{{ old('shop_social_links', $shop->social_links ?? '') }}</textarea>
                                        @error('shop_social_links')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('shop-owner.profile.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.cursor-pointer {
    cursor: pointer;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Profile image preview
    document.getElementById('profile_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profilePreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Profile Preview" class="rounded-circle border border-3 border-primary" style="width: 120px; height: 120px; object-fit: cover;">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Shop image preview
    document.getElementById('shop_profile_pic').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('shopPreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="Shop Preview" class="rounded border border-3 border-success" style="width: 120px; height: 120px; object-fit: cover;">`;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
