@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Sales Return Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales_returns.index') }}">Sales Returns</a></li>
                <li class="breadcrumb-item active">Sales Return Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sales Return Details</h5>

                        <div class="mb-3">
                            <label for="customer" class="form-label">Customer</label>
                            <input type="text" class="form-control" id="customer" value="{{ $salesReturn->customer->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="product" class="form-label">Product</label>
                            <input type="text" class="form-control" id="product" value="{{ $salesReturn->product->name }} - {{ $salesReturn->product->brand->name }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" value="{{ $salesReturn->quantity }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" value="{{ $salesReturn->price }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" class="form-control" id="total" value="{{ $salesReturn->total }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" value="{{ $salesReturn->date }}" readonly>
                        </div>

                        <a href="{{ route('sales_returns.index') }}" class="btn btn-primary">Back to Sales Returns</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
