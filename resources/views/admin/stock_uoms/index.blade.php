@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Stock Units of Measurement (UOM)</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Stock UOM</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Stock UOM List</h5>
                        <a href="{{ route('stock_uoms.create') }}" class="btn btn-primary mb-3">Add Stock UOM</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockUoms as $uom)
                                    <tr>
                                        <th scope="row">{{ $uom->id }}</th>
                                        <td>{{ $uom->name }}</td>
                                        <td>
                                            <a href="{{ route('stock_uoms.edit', $uom->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('stock_uoms.destroy', $uom->id) }}" method="POST" style="display:inline-block;">
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
