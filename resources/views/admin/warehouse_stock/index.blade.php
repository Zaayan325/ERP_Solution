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
                        <h5 class="card-title">Warehouse Stock List</h5>
                        <a href="{{ route('warehouse_stock.create') }}" class="btn btn-primary mb-3">Add Stock</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Warehouse</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <th scope="row">{{ $stock->id }}</th>
                                        <td>{{ $stock->warehouse->name }}</td>
                                        <td>{{ $stock->product->name }}</td>
                                        <td>{{ $stock->quantity }}</td>
                                        <td>
                                            <a href="{{ route('warehouse_stock.show', $stock->id) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('warehouse_stock.edit', $stock->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('warehouse_stock.destroy', $stock->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
