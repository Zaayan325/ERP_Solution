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

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Financial Overview</h5>
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

                        <h5 class="card-title">Sales and Purchases Over Time</h5>
                        <canvas id="salesPurchasesChart"></canvas>

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
                    labels: {!! json_encode($purchaseData->pluck('date')) !!},
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
</script>
@endpush
