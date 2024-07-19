@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Edit Sales Item</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales_items.index') }}">Sales Items</a></li>
                <li class="breadcrumb-item active">Edit Sales Item</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Sales Item</h5>

                        <form action="{{ route('sales_items.update', $salesItem->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="sale_id" class="form-label">Sale</label>
                                <select class="form-control" id="sale_id" name="sale_id" required>
                                    @foreach ($sales as $sale)
                                        <option value="{{ $sale->id }}" {{ $salesItem->sale_id == $sale->id ? 'selected' : '' }}>{{ $sale->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $salesItem->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $salesItem->quantity }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $salesItem->price }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
