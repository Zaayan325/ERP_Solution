@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Sales Returns</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Sales Returns</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <h5 class="card-title">Customer List</h5>
                        <a href="{{ route('sales_returns.create') }}" class="btn btn-primary mb-3">Add Sales Returns</a>

                        <h5 class="card-title">Sales Returns</h5>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Added At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salesReturns as $return)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $return->customer->name }}</td>
                                        <td>{{ $return->product->name }}</td>
                                        <td>{{ $return->quantity }}</td>
                                        <td>{{ $return->total }}</td>
                                        <td>{{ $return->created_at }}</td>
                                        <td>
                                            <a href="{{ route('sales_returns.show', $return->id) }}" class="btn btn-sm btn-info">View</a>
                                            <form action="{{ route('sales_returns.destroy', $return->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $salesReturns->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
