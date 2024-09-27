@extends('admin.layouts.main')

@section('content')
    <h1>Expenses</h1>

    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Add New Expense</a>

    <table class="table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td>{{ $expense->category->name }}</td>
                    <td>{{ number_format($expense->amount, 2) }}</td>
                    <td>{{ $expense->expense_date }}</td>
                    <td>{{ $expense->description ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $expenses->links() }}
    </div>
@endsection
