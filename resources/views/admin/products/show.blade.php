@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Product Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item active">Product Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Product: {{ $product->name }}</h5>
                        <p><strong>Description:</strong> {{ $product->description }}</p>
                        <p><strong>Category:</strong> {{ $product->category->name }}</p>
                        <p><strong>Brand:</strong> {{ $product->brand->name }}</p>
                        <p><strong>Unit of Measurement:</strong> {{ $product->uom->name }}</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
