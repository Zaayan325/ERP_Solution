@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Purchase Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                <li class="breadcrumb-item active">Purchase Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Purchase Details</h5>
                        <p><strong>Supplier:</strong> {{ $purchase->supplier->name }}</p>
                        <p><strong>Date:</strong> {{ $purchase->date }}</p>
                        <p><strong>Total Amount:</strong> {{ $purchase->total_amount }}</p>
                        <h5 class="card-title">Items</h5>
                        <ul>
                            @foreach ($purchase->items as $item)
                                <li>{{ $item->product->name }}: {{ $item->quantity }} x {{ $item->price }} = {{ $item->total }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('purchases.index') }}" class="btn btn-primary">Back to Purchases</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
