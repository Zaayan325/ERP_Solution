@extends('admin.layouts.main')

@section('content')
    <div class="pagetitle">
        <h1>Reports</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div>

    <!-- Product Filter for Stock at the top -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('reports.index') }}" id="productForm">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Select Product for Warehouse Stock</h5>
                                <div>
                                    <select class="form-control" name="product_id" id="product_id" onchange="updateReport()">
                                        <option value="all">All Products</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        <!-- Financial Overview -->
                        <h5 class="card-title" id="reportTitle">{{ request('product_id') == 'all' ? 'Financial Overview' : 'Financial Overview for ' . ($products->firstWhere('id', request('product_id'))->name ?? 'Selected Product') }}</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Purchases</td>
                                    <td>{{ number_format($netPurchases, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Sales</td>
                                    <td>{{ number_format($netSales, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Expenses</td>
                                    <td>{{ number_format($totalExpenses, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Profit</td>
                                    <td>{{ number_format($profit, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Stock In</td>
                                    <td>{{ number_format($totalStockIn, 0) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Stock Out</td>
                                    <td>{{ number_format($totalStockOut, 0) }}</td>
                                </tr>
                                <tr>
                                    <td>Current Stock</td>
                                    <td>{{ number_format($currentStock, 0) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Sales and Purchases Over Time -->
                        <h5 class="card-title">Sales and Purchases Over Time</h5>
                        <canvas id="salesPurchasesChart"></canvas>

                        <!-- Stock In and Out Over Time -->
                        <h5 class="card-title">Stock In and Out Over Time</h5>
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sales and Purchases Chart
        var ctx = document.getElementById('salesPurchasesChart');
        if (ctx) {
            var salesPurchasesChart = new Chart(ctx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($purchaseData->pluck('created_at')) !!},
                    datasets: [
                        {
                            label: 'Purchases',
                            data: {!! json_encode($purchaseData->pluck('amount')) !!},
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Sales',
                            data: {!! json_encode($salesData->pluck('amount')) !!},
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Stock In and Out Chart
        var stockCtx = document.getElementById('stockChart');
        if (stockCtx) {
            var stockChart = new Chart(stockCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($stockInData->pluck('date')) !!},
                    datasets: [
                        {
                            label: 'Stock In',
                            data: {!! json_encode($stockInData->pluck('quantity')) !!},
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Stock Out',
                            data: {!! json_encode($stockOutData->pluck('quantity')) !!},
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day'
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });

    // Function to submit the form and update the page
    function updateReport() {
        document.getElementById('productForm').submit();
    }
</script>
@endpush
