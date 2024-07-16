@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Warehouse Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('warehouses.index') }}">Warehouses</a></li>
                <li class="breadcrumb-item active">Warehouse Details</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Warehouse Details</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <p class="form-control">{{ $warehouse->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <p class="form-control">{{ $warehouse->location }}</p>
                        </div>
                        <a href="{{ route('warehouses.index') }}" class="btn btn-primary">Back to List</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
