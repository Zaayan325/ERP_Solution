@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Purchase Returns</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Purchase Returns</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Purchase Return List</h5>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchaseReturns as $purchaseReturn)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $purchaseReturn->supplier->name }}</td>
                                        <td>{{ $purchaseReturn->product->name }} - {{ $purchaseReturn->product->brand->name }}</td>
                                        <td>{{ $purchaseReturn->quantity }}</td>
                                        <td>{{ $purchaseReturn->total }}</td>
                                        <td>{{ $purchaseReturn->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('purchase_returns.show', $purchaseReturn->id) }}" class="btn btn-info btn-sm">View</a>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $purchaseReturns->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
