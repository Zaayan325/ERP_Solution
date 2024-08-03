@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Edit Sales Return</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales_returns.index') }}">Sales Returns</a></li>
                <li class="breadcrumb-item active">Edit Sales Return</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Sales Return</h5>

                        <form action="{{ route('sales_returns.update', $salesReturn->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select class="form-control" id="customer_id" name="customer_id" required>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $salesReturn->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $salesReturn->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }} - {{ $product->brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $salesReturn->quantity }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $salesReturn->price }}" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $salesReturn->date }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
