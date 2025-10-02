<form action="{{ !$category->id ? route('category.store') : route('category.update', $category->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($category->id ? 'PUT' : 'POST')
    <div class="row mt-2">
        <div class="col-md-12">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="{{old('name', $category->name ?? "")}}" minlength="3" maxlength="50" class="form-control " required>
            @error('name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="mt-3">
        <small class="text-muted">All field with * are Required</small>
    </div>
    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
