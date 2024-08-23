@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Current Stock</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Current Stock</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Current Stock Levels</h5>
                        <a href="{{ route('warehouse_stock.index') }}" class="btn btn-primary mb-3">Stock In List</a>
                        <a href="{{ route('warehouses.stockOutview') }}" class="btn btn-primary mb-3">Stock Out List</a>
                        <a href="{{ route('warehouse_stock.adjustments') }}" class="btn btn-primary mb-3">Stock Adjustment List</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Warehouse</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Model Number</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stock->warehouse->name }}</td>
                                        <td>{{ $stock->product->name }}</td>
                                        <td>{{ $stock->product->category->name ?? 'N/A' }}</td>
                                        <td>{{ $stock->product->brand->name ?? 'N/A' }}</td>
                                        <td>{{ $stock->product->model_no ?? 'N/A' }}</td>
                                        <td>{{ $stock->total_quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination links -->
                        {{ $stocks->links() }}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
