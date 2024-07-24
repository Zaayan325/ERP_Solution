@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Sales</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Sales</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sales List</h5>
                        <a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Add Sale</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <th scope="row">{{ $sale->id }}</th>
                                        <td>{{ $sale->customer->name }}</td>
                                        <td>{{ $sale->date }}</td>
                                        <td>{{ $sale->total_amount }}</td>
                                        <td>
                                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- {{ $sales->links() }} -->

                        <h5 class="card-title mt-4">Sales Items</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Sale ID</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    @foreach ($sale->items as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ $item->sale_id }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->product->brand->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
