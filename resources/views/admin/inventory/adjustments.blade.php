@extends('layouts.admin')

@section('content')
    <h1>Inventory Adjustments</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Adjustment Quantity</th>
                <th>Reason</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($adjustments as $adjustment)
                <tr>
                    <td>{{ $adjustment->product->name }}</td>
                    <td>{{ $adjustment->adjustment_quantity }}</td>
                    <td>{{ $adjustment->reason ?? 'N/A' }}</td>
                    <td>{{ $adjustment->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $adjustments->links() }}
    </div>
@endsection
