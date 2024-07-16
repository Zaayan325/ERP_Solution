@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Brands</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Brands</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Brand List</h5>
                        <a href="{{ route('brands.create') }}" class="btn btn-primary mb-3">Add Brand</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr>
                                        <th scope="row">{{ $brand->id }}</th>
                                        <td>{{ $brand->name }}</td>
                                        <td>
                                            <a href="{{ route('brands.edit', $brand->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
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
