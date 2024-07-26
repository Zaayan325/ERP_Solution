@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Add Purchase</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                <li class="breadcrumb-item active">Add Purchase</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Purchase</h5>

                        <form action="{{ route('purchases.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select class="form-control" id="supplier_id" name="supplier_id" required>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="products" class="form-label">Products</label>
                                <div id="products">
                                    <div class="product-item mb-3">
                                        <select class="form-control mb-2 product-select" name="items[0][product_id]" data-index="0" required>
                                            <option value="">Select a product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                    {{ $product->name }} - {{ $product->brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="number" class="form-control mb-2 product-quantity" name="items[0][quantity]" placeholder="Quantity" required>
                                        <input type="number" class="form-control mb-2 product-price" name="items[0][price]" placeholder="Price" step="0.01" required>
                                        <input type="number" class="form-control mb-2 product-total" name="items[0][total]" placeholder="Total" step="0.01" readonly>
                                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-product">Add Product</button>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('add-product').addEventListener('click', function () {
            const productItems = document.getElementById('products');
            const newIndex = productItems.children.length;
            const newProductItem = `
                <div class="product-item mb-3">
                    <select class="form-control mb-2 product-select" name="items[${newIndex}][product_id]" data-index="${newIndex}" required>
                        <option value="">Select a product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} - {{ $product->brand->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="number" class="form-control mb-2 product-quantity" name="items[${newIndex}][quantity]" placeholder="Quantity" required>
                    <input type="number" class="form-control mb-2 product-price" name="items[${newIndex}][price]" placeholder="Price" step="0.01" required>
                    <input type="number" class="form-control mb-2 product-total" name="items[${newIndex}][total]" placeholder="Total" step="0.01" readonly>
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                </div>
            `;
            productItems.insertAdjacentHTML('beforeend', newProductItem);
        });

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('product-select')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const priceInput = e.target.closest('.product-item').querySelector('.product-price');
                priceInput.value = selectedOption.getAttribute('data-price');
                updateTotal(e.target.closest('.product-item'));
            } else if (e.target.classList.contains('product-quantity') || e.target.classList.contains('product-price')) {
                updateTotal(e.target.closest('.product-item'));
            }
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-item').remove();
            }
        });

        function updateTotal(productItem) {
            const quantityInput = productItem.querySelector('.product-quantity');
            const priceInput = productItem.querySelector('.product-price');
            const totalInput = productItem.querySelector('.product-total');

            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const total = quantity * price;

            totalInput.value = total.toFixed(2);
        }
    </script>
@endsection
