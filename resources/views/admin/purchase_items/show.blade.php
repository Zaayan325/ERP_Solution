@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Purchase Item Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('purchase_items.index') }}">Purchase Items</a></li>
                <li class="breadcrumb-item active">Purchase Item Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Purchase Item Details</h5>
                        <p><strong>Purchase ID:</strong> {{ $purchaseItem->purchase->id }}</p>
                        <p><strong>Product:</strong> {{ $purchaseItem->product->name }}</p>
                        <p><strong>Quantity:</strong> {{ $purchaseItem->quantity }}</p>
                        <p><strong>Price:</strong> {{ $purchaseItem->price }}</p>
                        <p><strong>Total:</strong> {{ $purchaseItem->total }}</p>
                        <a href="{{ route('purchase_items.index') }}" class="btn btn-primary">Back to Purchase Items</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
