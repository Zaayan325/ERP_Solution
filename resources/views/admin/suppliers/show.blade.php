@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Supplier Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
                <li class="breadcrumb-item active">Supplier Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Supplier: {{ $supplier->name }}</h5>
                        <p><strong>Email:</strong> {{ $supplier->email }}</p>
                        <p><strong>Phone:</strong> {{ $supplier->phone }}</p>
                        <p><strong>Address:</strong> {{ $supplier->address }}</p>
                        <a href="{{ route('suppliers.index') }}" class="btn btn-primary">Back to Suppliers</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
