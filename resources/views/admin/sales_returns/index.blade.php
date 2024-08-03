@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Sales Returns</h1>
        <a href="{{ route('sales_returns.create') }}" class="btn btn-primary mb-3">Add Sales Return</a>
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
                        <h5 class="card-title">Sales Return List</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($salesReturns as $return)
                                    <tr>
                                        <td>{{ $return->id }}</td>
                                        <td>{{ $return->customer->name }}</td>
                                        <td>{{ $return->product->name }} ({{ $return->product->brand->name }})</td>
                                        <td>{{ $return->quantity }}</td>
                                        <td>{{ $return->price }}</td>
                                        <td>{{ $return->total }}</td>
                                        <td>{{ $return->date }}</td>
                                        <td>
                                            <a href="{{ route('sales_returns.show', $return->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('sales_returns.edit', $return->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('sales_returns.destroy', $return->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
