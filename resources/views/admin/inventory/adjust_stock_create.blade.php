@extends('layouts.admin')

@section('content')
    <h1>Adjust Inventory</h1>

    <form action="{{ route('inventory.adjustments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="" disabled selected>Choose a product</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="adjustment_quantity" class="form-label">Adjustment Quantity</label>
            <input type="number" name="adjustment_quantity" id="adjustment_quantity" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="reason" class="form-label">Reason (Optional)</label>
            <input type="text" name="reason" id="reason" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit Adjustment</button>
    </form>
@endsection
