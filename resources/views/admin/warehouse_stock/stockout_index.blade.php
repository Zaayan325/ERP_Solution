    @extends('admin.layouts.main')

    @section('content')
        <div class="pagetitle">
            <h1>Warehouse Stock</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Warehouse Stock</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Stock Entries</h5>

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
                                        <th>Added On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($warehouseStocksOut as $stock)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $stock->warehouse->name }}</td>
                                            <td>{{ $stock->product->name }}</td>
                                            <td>{{ $stock->product->category->name ?? 'N/A' }}</td>
                                            <td>{{ $stock->product->brand->name ?? 'N/A' }}</td>
                                            <td>{{ $stock->product->model_no ?? 'N/A' }}</td>
                                            <td>{{ $stock->quantity }}</td>
                                            <td>{{ $stock->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination links -->
                            {{ $warehouseStocksOut->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
