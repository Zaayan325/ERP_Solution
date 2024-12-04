@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Create Sale</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                <li class="breadcrumb-item active">Create Sale</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">New Sale</h5>

                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select class="form-control" id="customer_id" name="customer_id" required>
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Products</label>
                                <table class="table" id="products-table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="products-body">
                                        <tr>
                                            <td>
                                                <select name="items[0][product_id]" class="form-control" required>
                                                    <option value="">Select Product</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="items[0][quantity]" class="form-control" required></td>
                                            <td><input type="number" name="items[0][price]" class="form-control" required></td>
                                            <td><button type="button" class="btn btn-danger remove-product">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" id="add-product">Add Product</button>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Sale</button>
                            <a class="btn btn-primary" href="{{ route('sales.index') }}"
                             role="button">View Sales</a>
                          
                          <br><br> <a class="btn btn-primary" href="{{ route('sales_items.index') }}"
                           role="button">View Sales Items</a>
                           
                          <a class="btn btn-primary" href="{{ route('payments.index') }}"
                           role="button">View Payments</a>
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

        document.getElementById('add-product').addEventListener('click', function() {
            const productsTableBody = document.getElementById('products-body');
            const newRow = `
                <tr>
                    <td>
                        <select name="items[${productIndex}][product_id]" class="form-control" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="items[${productIndex}][quantity]" class="form-control" required></td>
                    <td><input type="number" name="items[${productIndex}][price]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-danger remove-product">Remove</button></td>
                </tr>
            `;
            productsTableBody.insertAdjacentHTML('beforeend', newRow);
            productIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-product')) {
                e.target.closest('tr').remove();
            }
        });
    });
</script>
@endpush
