@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Stock Brands</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Stock Brands</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stock Brand List</h5>
                        <a href="{{ route('stock_brands.create') }}" class="btn btn-primary mb-3">Add Stock Brand</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockBrands as $brand)
                                    <tr>
                                        <th scope="row">{{ $brand->id }}</th>
                                        <td>{{ $brand->name }}</td>
                                        <td>
                                            <a href="{{ route('stock_brands.edit', $brand->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('stock_brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
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
