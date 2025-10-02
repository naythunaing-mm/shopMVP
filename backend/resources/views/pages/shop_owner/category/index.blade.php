@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Category List') }}</h5>
                    <a href="{{ route('category.create') }}" class="btn btn-sm btn-primary">
                        + Add Category
                    </a>
                </div>

                <div class="card-body">
                    @if($categories->count())
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Name</th>
                                    <th>Shop</th>
                                    <th width="200">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration + ($categories->firstItem() - 1) }}</th>
                                        <td class="text-capitalize">{{ $category->name }}</td>
                                        <td class="text-capitalize">{{ $category->shop->name }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('category.show', $category->id) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <form action="{{ route('category.destroy', $category->id) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted mb-0">No categories found.</p>
                    @endif
                </div>

                <div class="card-footer">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
