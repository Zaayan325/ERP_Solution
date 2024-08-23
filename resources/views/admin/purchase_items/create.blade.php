@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Add Purchase Item</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('purchase_items.index') }}">Purchase Items</a></li>
                <li class="breadcrumb-item active">Add Purchase Item</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Purchase Item</h5>

                        <form action="{{ route('purchase_items.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="purchase_id" class="form-label">Purchase</label>
                                <select class="form-control" id="purchase_id" name="purchase_id" required>
                                    @foreach ($purchases as $purchase)
                                        <option value="{{ $purchase->id }}">{{ $purchase->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-primary" href="{{ route('purchase_items.index') }}" role="button">View Purchase Items</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
