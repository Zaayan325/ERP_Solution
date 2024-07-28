@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Reports</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reports</h5>

                        <!-- Tabs -->
                        <ul class="nav nav-tabs" id="reportTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="purchase-tab" data-bs-toggle="tab" href="#purchase" role="tab" aria-controls="purchase" aria-selected="true">Purchase Report</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="purchase-return-tab" data-bs-toggle="tab" href="#purchase-return" role="tab" aria-controls="purchase-return" aria-selected="false">Purchase Return Report</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Sales Report</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="sales-return-tab" data-bs-toggle="tab" href="#sales-return" role="tab" aria-controls="sales-return" aria-selected="false">Sales Return Report</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="stock-tab" data-bs-toggle="tab" href="#stock" role="tab" aria-controls="stock" aria-selected="false">Stock Report</a>
                            </li>
                        </ul>

                        <!-- Tab Contents -->
                        <div class="tab-content" id="reportTabsContent">
                            <!-- Purchase Report -->
                            <div class="tab-pane fade show active" id="purchase" role="tabpanel" aria-labelledby="purchase-tab">
                                <table class="table mt-3">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Supplier</th>
                                            <th>Date</th>
                                            <th>Total Amount</th>
                                            <th>Products</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchases as $purchase)
                                            <tr>
                                                <td>{{ $purchase->id }}</td>
                                                <td>{{ $purchase->supplier->name }}</td>
                                                <td>{{ $purchase->date }}</td>
                                                <td>{{ $purchase->total_amount }}</td>
                                                <td>
                                                    @foreach ($purchase->items as $item)
                                                        <p>{{ $item->product->name }} ({{ $item->product->brand->name }}): {{ $item->quantity }} x {{ $item->price }} = {{ $item->total }}</p>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Purchase Return Report -->
                            <div class="tab-pane fade" id="purchase-return" role="tabpanel" aria-labelledby="purchase-return-tab">
                                <table class="table mt-3">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Supplier</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchaseReturns as $return)
                                            <tr>
                                                <td>{{ $return->id }}</td>
                                                <td>{{ $return->purchase->supplier->name }}</td>
                                                <td>{{ $return->product->name }} ({{ $return->product->brand->name }})</td>
                                                <td>{{ $return->quantity }}</td>
                                                <td>{{ $return->price }}</td>
                                                <td>{{ $return->total }}</td>
                                                <td>{{ $return->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Sales Report -->
                            <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                                <table class="table mt-3">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                            <th>Total Amount</th>
                                            <th>Products</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td>{{ $sale->id }}</td>
                                                <td>{{ $sale->customer->name }}</td>
                                                <td>{{ $sale->date }}</td>
                                                <td>{{ $sale->total_amount }}</td>
                                                <td>
                                                    @foreach ($sale->items as $item)
                                                        <p>{{ $item->product->name }} ({{ $item->product->brand->name }}): {{ $item->quantity }} x {{ $item->price }} = {{ $item->total }}</p>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Sales Return Report -->
                            <div class="tab-pane fade" id="sales-return" role="tabpanel" aria-labelledby="sales-return-tab">
                                <table class="table mt-3">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($salesReturns as $return)
                                            <tr>
                                                <td>{{ $return->id }}</td>
                                                <td>{{ $return->sale->customer->name }}</td>
                                                <td>{{ $return->product->name }} ({{ $return->product->brand->name }})</td>
                                                <td>{{ $return->quantity }}</td>
                                                <td>{{ $return->price }}</td>
                                                <td>{{ $return->total }}</td>
                                                <td>{{ $return->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Stock Report -->
                            <div class="tab-pane fade" id="stock" role="tabpanel" aria-labelledby="stock-tab">
                                <table class="table mt-3">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Brand</th>
                                            <th>Stock</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->brand->name }}</td>
                                                <td>{{ $product->stock }}</td>
                                                <td>{{ $product->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
