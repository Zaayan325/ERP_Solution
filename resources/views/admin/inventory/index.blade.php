@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Inventory</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inventory List</h5>
                        <a href="{{ route('inventory.create') }}" class="btn btn-primary mb-3">Update Inventory</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Reorder Level</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventory as $item)
                                    <tr>
                                        <th scope="row">{{ $item->id }}</th>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->reorder_level }}</td>
                                        <td>
                                            <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" style="display:inline-block;">
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
