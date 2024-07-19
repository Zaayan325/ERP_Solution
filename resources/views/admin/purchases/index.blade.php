@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Purchases</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Purchases</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Purchase List</h5>
                        <a href="{{ route('purchases.create') }}" class="btn btn-primary mb-3">Add Purchase</a>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Supplier</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                    <tr>
                                        <th scope="row">{{ $purchase->id }}</th>
                                        <td>{{ $purchase->supplier->name }}</td>
                                        <td>{{ $purchase->date }}</td>
                                        <td>{{ $purchase->total_amount }}</td>
                                        <td>
                                            <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-info">View</a>
                                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" style="display:inline-block;">
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
