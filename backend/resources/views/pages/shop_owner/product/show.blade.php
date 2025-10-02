@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product Details') }}</div>

                <div class="card-body">
                    <h3>{{ $product->name }}</h3>

                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded mb-3">
                    @endif

                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>

                    @if($product->description)
                        <p><strong>Description:</strong> {{ $product->description }}</p>
                    @else
                        <p class="text-muted">No description available.</p>
                    @endif

                    @if($product->colors)
                        <p><strong>Available Colors:</strong> {{ $product->colors }}</p>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">
                            Edit Product
                        </a>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
