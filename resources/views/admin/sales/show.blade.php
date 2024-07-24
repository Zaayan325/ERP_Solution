@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>View Sale</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                <li class="breadcrumb-item active">View Sale</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sale Details</h5>

                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <p>{{ $sale->customer->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <p>{{ $sale->date }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="products" class="form-label">Products</label>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Brand</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sale->items as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->product->brand->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount</label>
                            <p>{{ $sale->total_amount }}</p>
                        </div>

                        <a href="{{ route('sales.index') }}" class="btn btn-primary">Back to Sales</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
