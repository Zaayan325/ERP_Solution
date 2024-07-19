@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Edit Purchase</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                <li class="breadcrumb-item active">Edit Purchase</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Purchase</h5>

                        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select class="form-control" id="supplier_id" name="supplier_id" required>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" value="{{ $purchase->date }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="items" class="form-label">Items</label>
                                <div id="items">
                                    @foreach ($purchase->items as $index => $item)
                                        <div class="item">
                                            <select class="form-control mb-2" name="items[{{ $index }}][product_id]" required>
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="number" class="form-control mb-2" name="items[{{ $index }}][quantity]" placeholder="Quantity" value="{{ $item->quantity }}" required>
                                            <input type="number" class="form-control mb-2" name="items[{{ $index }}][price]" placeholder="Price" value="{{ $item->price }}" step="0.01" required>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-secondary" id="add-item">Add Item</button>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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
            <input type="number" class="form-control mb-2" name="items[${itemCount}][price]" placeholder="Price" step="0.01" required>
        `;
        items.appendChild(newItem);
    });
</script>
@endpush
