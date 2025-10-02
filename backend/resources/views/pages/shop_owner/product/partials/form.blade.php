<form action="{{ !$product->id ? route('product.store') : route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($product->id ? 'PUT' : 'POST')

    <div class="row mt-2">
        <div class="col-md-12">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $product->name ?? '') }}" minlength="3" maxlength="255" class="form-control" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6">
            <label for="price">Price *</label>
            <input type="number" id="price" name="price" value="{{ old('price', $product->price ?? '') }}" class="form-control" required>
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="discount">Discount (%)</label>
            <input type="number" id="discount" name="discount" value="{{ old('discount', $product->discount ?? '') }}" class="form-control">
            @error('discount')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <label for="pics">Picture</label>
            <input type="file" id="pics" name="pics" class="form-control">
            @if(isset($product->pics))
                <img src="{{ asset('storage/' . $product->pics) }}" width="50" class="mt-2">
            @endif
            @error('pics')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-12">
            <label for="video">Video URL</label>
            <input type="url" id="video" name="video" value="{{ old('video', $product->video ?? '') }}" class="form-control">
            @error('video')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6">
            <label for="types">Types</label>
            <input type="text" id="types" name="types" value="{{ old('types', $product->types ?? '') }}" class="form-control">
            @error('types')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="color-picker">Colors</label>
            <input type="hidden" id="colors" name="colors" value="{{ old('colors', $product->colors ?? '') }}"/>
            <div id="product-colors" class="d-flex flex-wrap"></div>
            <div class="row">
                <input type="color" id="color-picker" class="form-control my-3"/>
                <button class="btn btn-primary" id="add-product-color">Add</button>
            </div>

            @error('colors')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-6">
            <label for="stock">Stock *</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock ?? '') }}" class="form-control" required>
            @error('stock')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="category_id">Category *</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>

    @if(auth()->user()->hasRole('admin'))
    <div class="row mt-2">
        <div class="col-md-12">
            <label for="shop_id">Shop *</label>
            <select id="shop_id" name="shop_id" class="form-control" required>
                <option value="">-- Select Shop --</option>
                @foreach($shops as $shop)
                    <option value="{{ $shop->id }}" {{ old('shop_id', $product->shop_id ?? '') == $shop->id ? 'selected' : '' }}>
                        {{ $shop->name }}
                    </option>
                @endforeach
            </select>
            @error('shop_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    @endif
    </div>

    <div class="mt-3">
        <small class="text-muted">All fields marked with * are required.</small>
    </div>
    <div class="d-grid gap-2 mt-3">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
