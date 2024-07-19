@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Suppliers</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Suppliers</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Supplier List</h5>
                        <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Add Supplier</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <th scope="row">{{ $supplier->id }}</th>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>
                                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline-block;">
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
