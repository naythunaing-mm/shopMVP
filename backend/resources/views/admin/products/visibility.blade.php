@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Product Visibility Management</h4>
                    <p class="text-muted">Control which products are visible on the frontend</p>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <span class="badge badge-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $product->is_featured ? 'warning' : 'light' }}">
                                            {{ $product->is_featured ? 'Featured' : 'Normal' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.products.toggle-status', $product->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-{{ $product->status === 'active' ? 'warning' : 'success' }}">
                                                {{ $product->status === 'active' ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('admin.products.toggle-featured', $product->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-{{ $product->is_featured ? 'outline-warning' : 'warning' }}">
                                                {{ $product->is_featured ? 'Unfeature' : 'Feature' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $products->links() }}
                    </div>

                    <div class="alert alert-info mt-4">
                        <h6>Current Frontend Filtering Rules:</h6>
                        <ul class="mb-0">
                            <li><strong>Status:</strong> Only "Active" products are shown</li>
                            <li><strong>Stock:</strong> Only products with stock > 0 are shown</li>
                            <li><strong>Images:</strong> Only the first image is displayed per product</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
