@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>My Shops</h4>
                        <a href="{{ route('shop.create') }}" class="btn btn-primary">Create New Shop</a>
                    </div>
                    <div class="card-body">
                        @if(!empty($shops) && $shops->count() > 0)

                            <div class="row">
                                @foreach($shops as $shop)
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            <div class="card-header d-flex align-items-center">
                                               @if($shop && $shop->profile_pic)
                                                    <img src="{{ asset($shop->profile_pic) }}" alt="Shop Image" width="40" height="40" class="me-3 rounded">
                                                @endif
                                                <h5 class="mb-0">{{ $shop->name }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-muted">{{ $shop->description ?? 'No description' }}</p>
                                                <p class="small">
                                                    <strong>Address:</strong> {{ $shop->address ?? 'Not set' }}<br>
                                                    <strong>Phone:</strong> {{ $shop->phone ?? 'Not set' }}
                                                </p>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('shop.show', $shop) }}" class="btn btn-sm btn-outline-primary">View</a>
                                                    <a href="{{ route('shop.edit', $shop) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                                                                        <form action="{{ route('shop.destroy', $shop) }}" method="POST" class="d-inline">

                                                    <form action="{{ route('shop.destroy', $shop) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete {{ $shop->name }}? This cannot be undone.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <h5>No shops created yet</h5>
                                <p class="text-muted">Create your first shop to get started</p>
                                <a href="{{ route('shop.create') }}" class="btn btn-primary">Create Your First Shop</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
