@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Return Sale</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                <li class="breadcrumb-item active">Return Sale</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Return Sale</h5>

                        <form action="{{ route('sales.returnStore', $sale->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="products" class="form-label">Products</label>
                                <div id="products">
                                    @foreach ($products as $index => $product)
                                        <div class="product-item mb-3">
                                            <select class="form-control mb-2 product-select" name="items[{{ $index }}][product_id]" data-index="{{ $index }}" required>
                                                <option value="{{ $product->id }}">{{ $product->name }} - {{ $product->brand->name }}</option>
                                            </select>
                                            <input type="number" class="form-control mb-2 product-quantity" name="items[{{ $index }}][quantity]" value="{{ $sale->items->where('product_id', $product->id)->first()->quantity }}" placeholder="Quantity" required>
                                            <input type="number" class="form-control mb-2 product-price" name="items[{{ $index }}][price]" value="{{ $sale->items->where('product_id', $product->id)->first()->price }}" placeholder="Price" step="0.01" required>
                                            <input type="number" class="form-control mb-2 product-total" name="items[{{ $index }}][total]" value="{{ $sale->items->where('product_id', $product->id)->first()->total }}" placeholder="Total" step="0.01" readonly>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('product-quantity') || e.target.classList.contains('product-price')) {
                updateTotal(e.target.closest('.product-item'));
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
