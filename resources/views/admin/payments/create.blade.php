@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Add Payment</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
                <li class="breadcrumb-item active">Add Payment</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Payment</h5>

                        <form action="{{ route('payments.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="sale_id" class="form-label">Sale</label>
                                <select class="form-control" id="sale_id" name="sale_id" required>
                                    @foreach ($sales as $sale)
                                        <option value="{{ $sale->id }}">{{ $sale->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="payment_date" class="form-label">Payment Date</label>
                                <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
