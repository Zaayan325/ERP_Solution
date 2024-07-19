@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Edit Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}">Inventory</a></li>
                <li class="breadcrumb-item active">Edit Inventory</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Inventory</h5>

                        <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-control" id="product_id" name="product_id" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $inventory->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $inventory->quantity }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="reorder_level" class="form-label">Reorder Level</label>
                                <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="{{ $inventory->reorder_level }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
