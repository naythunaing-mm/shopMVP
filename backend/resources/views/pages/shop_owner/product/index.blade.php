@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-box"></i> Product List</h4>
            <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>

        <div class="card-body p-0">
            @if($products->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Shop</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Stock</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $index => $product)
                                <tr>
                                    <!-- Serial number -->
                                    <td>{{ $products->firstItem() + $index }}</td>

                                    <!-- Image first column -->
                                    <td>
                                        @if($product->pics && file_exists(public_path('storage/' . $product->pics)))
                                            <img src="{{ asset('storage/' . $product->pics) }}" 
                                                 width="50" height="50" 
                                                 class="rounded border">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    <!-- Name after image -->
                                    <td class="fw-semibold">{{ $product->name }}</td>
                                    <td>{{ optional($product->category)->name ?? '—' }}</td>
                                    <td>{{ optional($product->shop)->name ?? '—' }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        @if($product->discount)
                                            <span class="badge bg-success">{{ $product->discount }}%</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->stock > 0)
                                            <span class="badge bg-primary">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Out</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="{{ route('product.show', $product) }}" 
                                               class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('product.edit', $product->id) }}" 
                                               class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('product.destroy', $product->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center p-4 mb-0">
                    <i class="fas fa-info-circle"></i> No products found.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
