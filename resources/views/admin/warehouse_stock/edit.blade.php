@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Edit Stock</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('warehouse_stock.index') }}">Warehouse Stock</a></li>
                <li class="breadcrumb-item active">Edit Stock</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Stock</h5>

                        <form action="{{ route('warehouse_stock.update', $stock->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="warehouse" class="form-label">Warehouse</label>
                                <select class="form-control" id="warehouse" name="warehouse_id" required>
                                    @foreach($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}" {{ $stock->warehouse_id == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="product" class="form-label">Product</label>
                                <select class="form-control" id="product" name="product_id" required>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ $stock->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $stock->quantity }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
