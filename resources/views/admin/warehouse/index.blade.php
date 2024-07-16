@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Warehouses</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Warehouses</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Warehouse List</h5>
                        <a href="{{ route('warehouses.create') }}" class="btn btn-primary mb-3">Add Warehouse</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <th scope="row">{{ $warehouse->id }}</th>
                                        <td>{{ $warehouse->name }}</td>
                                        <td>{{ $warehouse->location }}</td>
                                        <td>
                                            <a href="{{ route('warehouses.show', $warehouse->id) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" style="display:inline-block;">
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
