@extends('admin.layouts.main')

@section('content')
    <h1>Current Inventory</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Current Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($currentInventory as $inventory)
                <tr>
                    <td>{{ $inventory->product->name }}</td>
                    <td>{{ $inventory->total_quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
