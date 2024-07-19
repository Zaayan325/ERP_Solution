@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Add Sale</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                <li class="breadcrumb-item active">Add Sale</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Sale</h5>

                        <form action="{{ route('sales.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer</label>
                                <select class="form-control" id="customer_id" name="customer_id" required>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="items" class="form-label">Items</label>
                                <div id="items">
                                    <div class="item">
                                        <select class="form-control mb-2" name="items[0][product_id]" required>
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" class="form-control mb-2" name="items[0][quantity]" placeholder="Quantity" required>
                                        <input type="number" class="form-control mb-2" name="items[0][price]" placeholder="Price" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-item">Add Item</button>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('add-item').addEventListener('click', function() {
        var items = document.getElementById('items');
        var itemCount = items.getElementsByClassName('item').length;
        var newItem = document.createElement('div');
        newItem.className = 'item';
        newItem.innerHTML = `
            <select class="form-control mb-2" name="items[${itemCount}][product_id]" required>
                <option value="">Select Product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <input type="number" class="form-control mb-2" name="items[${itemCount}][quantity]" placeholder="Quantity" required>
            <input type="number" class="form-control mb-2" name="items[${itemCount}][price]" placeholder="Price" required>
        `;
        items.appendChild(newItem);
    });
</script>
@endpush
