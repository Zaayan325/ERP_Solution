@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Stock Adjustments</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Stock Adjustments</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stock Adjustment History</h5>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Warehouse</th>
                                    <th>Product</th>
                                    <th>Adjustment Quantity</th>
                                    <th>Reason</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adjustments as $adjustment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $adjustment->warehouse->name }}</td>
                                        <td>{{ $adjustment->product->name }}</td>
                                        <td>{{ $adjustment->adjustment_quantity }}</td>
                                        <td>{{ $adjustment->reason ?? 'N/A' }}</td>
                                        <td>{{ $adjustment->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $adjustments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
