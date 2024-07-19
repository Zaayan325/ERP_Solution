@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Sale Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                <li class="breadcrumb-item active">Sale Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sale Details</h5>
                        <p><strong>Customer:</strong> {{ $sale->customer->name }}</p>
                        <p><strong>Date:</strong> {{ $sale->date }}</p>
                        <p><strong>Total Amount:</strong> {{ $sale->total_amount }}</p>
                        <h5 class="card-title">Items</h5>
                        <ul>
                            @foreach ($sale->items as $item)
                                <li>{{ $item->product->name }}: {{ $item->quantity }} x {{ $item->price }} = {{ $item->total }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('sales.index') }}" class="btn btn-primary">Back to Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
