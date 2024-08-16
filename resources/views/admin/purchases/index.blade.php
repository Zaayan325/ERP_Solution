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

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchases as $purchase)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $purchase->supplier->name }}</td>
                                        <td>{{ $purchase->total_amount }}</td>
                                        <td>{{ $purchase->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $purchases->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
