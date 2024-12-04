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
                                <label for="products" class="form-label">Products</label>
                                <div id="products">
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <label for="product_id" class="form-label">Product</label>
                                            <select class="form-control" name="items[0][product_id]" required>
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" name="items[0][quantity]" placeholder="Quantity" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" class="form-control" name="items[0][price]" placeholder="Price" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-product">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="addProduct" class="btn btn-primary">Add Another Product</button>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Purchase</button>
                            <a class="btn btn-primary" href="{{ route('purchases.index') }}"
                             role="button">View Purchases</a>

                             <a class="btn btn-primary" href="{{ route('purchase_items.index') }}"
                           role="button">View Purchase Items</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let productIndex = 1;

        // Add new product row
        document.getElementById('addProduct').addEventListener('click', function() {
            const productsDiv = document.getElementById('products');
            const newProductRow = `
                <div class="row mb-2">
                    <div class="col-md-4">
                        <select class="form-control" name="items[${productIndex}][product_id]" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="items[${productIndex}][quantity]" placeholder="Quantity" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="items[${productIndex}][price]" placeholder="Price" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                    </div>
                </div>
            `;
            productsDiv.insertAdjacentHTML('beforeend', newProductRow);
            productIndex++;
        });

        // Remove product row
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-product')) {
                e.target.closest('.row').remove();
            }
        });
    });
</script>
@endpush
