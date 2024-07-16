@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Stock Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('warehouse_stock.index') }}">Warehouse Stock</a></li>
                <li class="breadcrumb-item active">Stock Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stock Details</h5>

                        <div class="mb-3">
                            <label for="warehouse" class="form-label">Warehouse</label>
                            <p class="form-control">{{ $stock->warehouse->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="product" class="form-label">Product</label>
                            <p class="form-control">{{ $stock->product->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <p class="form-control">{{ $stock->quantity }}</p>
                        </div>
                        <a href="{{ route('warehouse_stock.index') }}" class="btn btn-primary">Back to List</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
