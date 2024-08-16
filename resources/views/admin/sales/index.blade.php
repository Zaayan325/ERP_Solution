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
                        <h5 class="card-title">Sales</h5>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Added At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sale->customer->name }}</td>
                                        <td>{{ $sale->total_amount }}</td>
                                        <td>{{ $sale->created_at }}</td>
                                        <td>
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info">View</a>
                                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
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
