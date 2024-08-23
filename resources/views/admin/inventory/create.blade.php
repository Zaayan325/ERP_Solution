@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Update Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
                <li class="breadcrumb-item active">Update Inventory</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Update Inventory</h5>

                        <form action="{{ route('inventory.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="reorder_level" class="form-label">Reorder Level</label>
                                <input type="number" class="form-control" id="reorder_level" name="reorder_level" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-primary" href="{{ route('inventory.index') }}" role="button">View Inventory</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
