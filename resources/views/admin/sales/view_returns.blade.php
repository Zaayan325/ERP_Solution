@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Sales Returns</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                <li class="breadcrumb-item active">Sales Returns</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sales Returns</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale->returns as $return)
                                    <tr>
                                        <th scope="row">{{ $return->id }}</th>
                                        <td>{{ $return->product->name }}</td>
                                        <td>{{ $return->quantity }}</td>
                                        <td>{{ $return->price }}</td>
                                        <td>{{ $return->total }}</td>
                                        <td>{{ $return->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('sales.index') }}" class="btn btn-primary">Back to Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
