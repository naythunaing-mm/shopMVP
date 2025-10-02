@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                           @if($shop && $shop->profile_pic)
                                <img src="{{ asset($shop->profile_pic) }}" alt="Shop Image" width="50" height="50" class="me-3 rounded">
                            @endif
                            <h4 class="mb-0">{{ $shop->name }}</h4>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('shop.edit', $shop) }}" class="btn btn-outline-primary">Edit</a>
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">Back to Shops</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Description</h6>
                                <p>{{ $shop->description ?? 'No description provided' }}</p>
                                
                                <h6>Contact Information</h6>
                                <p><strong>Phone:</strong> {{ $shop->phone }}</p>
                                <p><strong>Address:</strong> {{ $shop->address }}</p>
                                @if($shop->street)
                                    <p><strong>Street:</strong> {{ $shop->street }}</p>
                                @endif
                                @if($shop->unit)
                                    <p><strong>Unit:</strong> {{ $shop->unit }}</p>
                                @endif
                                <p><strong>Postal Code:</strong> {{ $shop->postal_code }}</p>
                            </div>
                            <div class="col-md-6">
                                @if($shop->social_links)
                                    <h6>Social Links</h6>
                                    <p>{{ $shop->social_links }}</p>
                                @endif
                                
                                <h6>Shop Statistics</h6>
                                <p><strong>Products:</strong> {{ $shop->products()->count() }}</p>
                                <p><strong>Categories:</strong> {{ $shop->categories()->count() }}</p>
                                <p><strong>Created:</strong> {{ $shop->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex gap-2">
                            <a href="{{ route('product.index') }}?shop_id={{ $shop->id }}" class="btn btn-outline-info">Manage Products</a>
                            <form action="{{ route('shop.destroy', $shop) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete {{ $shop->name }}? This will also delete all products and cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger" type="submit">Delete Shop</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
