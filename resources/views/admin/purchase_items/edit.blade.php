@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Edit Purchase Item</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('purchase_items.index') }}">Purchase Items</a></li>
                <li class="breadcrumb-item active">Edit Purchase Item</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Purchase Item</h5>

                        <form action="{{ route('purchase_items.update', $purchaseItem->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="purchase_id" class="form-label">Purchase</label>
                                <select class="form-control" id="purchase_id" name="purchase_id" required>
                                    @foreach ($purchases as $purchase)
                                        <option value="{{ $purchase->id }}" {{ $purchaseItem->purchase_id == $purchase->id ? 'selected' : '' }}>{{ $purchase->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $purchaseItem->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $purchaseItem->quantity }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $purchaseItem->price }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
