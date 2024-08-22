@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Edit Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Edit Product</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Product</h5>

                        <form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
    </div>
    <div class="mb-3">
        <label for="model_no" class="form-label">Model No</label>
        <input type="text" class="form-control" id="model_no" name="model_no" value="{{ old('model_no', $product->model_no) }}">
    </div>
    <div class="mb-3">
        <label for="product_category_id" class="form-label">Product Category</label>
        <select class="form-control" id="product_category_id" name="product_category_id" required>
            @foreach ($productCategories as $category)
                <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="brand_id" class="form-label">Brand</label>
        <select class="form-control" id="brand_id" name="brand_id" required>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="uom_id" class="form-label">Unit of Measurement</label>
        <select class="form-control" id="uom_id" name="uom_id" required>
            @foreach ($uoms as $uom)
                <option value="{{ $uom->id }}" {{ old('uom_id', $product->uom_id) == $uom->id ? 'selected' : '' }}>{{ $uom->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
    
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
