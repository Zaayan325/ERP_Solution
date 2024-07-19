@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Customer Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
                <li class="breadcrumb-item active">Customer Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer: {{ $customer->name }}</h5>
                        <p><strong>Email:</strong> {{ $customer->email }}</p>
                        <p><strong>Phone:</strong> {{ $customer->phone }}</p>
                        <p><strong>Address:</strong> {{ $customer->address }}</p>
                        <a href="{{ route('customers.index') }}" class="btn btn-primary">Back to Customers</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
