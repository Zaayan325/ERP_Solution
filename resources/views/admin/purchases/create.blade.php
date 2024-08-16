@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Create Purchase</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                <li class="breadcrumb-item active">Create Purchase</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create Purchase</h5>

                        <form action="{{ route('purchases.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select class="form-control" id="supplier_id" name="supplier_id" required>
                                    <option value="">Select Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="items" class="form-label">Products</label>
                                <div id="products">
                                    @foreach ($products as $product)
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $product->id }}">
                                                {{ $product->name }} ({{ $product->brand->name }})
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" class="form-control" name="items[{{ $loop->index }}][quantity]" placeholder="Quantity" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" class="form-control" name="items[{{ $loop->index }}][price]" placeholder="Price" required>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Purchase</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
