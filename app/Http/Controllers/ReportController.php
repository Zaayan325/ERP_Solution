<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SalesReturn;
use App\Models\Product;
use App\Models\WarehouseStock;
use App\Models\WarehouseStockOut;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Get all necessary data
        $purchases = Purchase::with('supplier', 'items.product.brand')->get();
        $purchaseReturns = PurchaseReturn::with('purchase.supplier', 'product.brand')->get();
        $sales = Sale::with('customer', 'items.product.brand')->get();
        $salesReturns = SalesReturn::with('sale.customer', 'product.brand')->get();

        // Warehouse Stock Data
        $stockIns = WarehouseStock::with('product', 'warehouse')->get();
        $stockOuts = WarehouseStockOut::with('product', 'warehouse')->get();

        // Calculate total amounts
        $totalPurchase = $purchases->sum('total_amount');
        $totalPurchaseReturn = $purchaseReturns->sum('total');
        $totalSales = $sales->sum('total_amount');
        $totalSalesReturn = $salesReturns->sum('total');

        // Calculate net sales, net purchases, and profit
        $netPurchases = $totalPurchase - $totalPurchaseReturn;
        $netSales = $totalSales - $totalSalesReturn;
        $profit = $netSales - $netPurchases;

        // Warehouse stock report
        $totalStockIn = $stockIns->sum('quantity');
        $totalStockOut = $stockOuts->sum('quantity');
        $currentStock = $totalStockIn - $totalStockOut;

        // Data for charts
        $purchaseData = $purchases->map(function ($purchase) {
            return [
                'created_at' => $purchase->created_at->format('Y-m-d'),
                'amount' => $purchase->total_amount,
            ];
        });

        $salesData = $sales->map(function ($sale) {
            return [
                'created_at' => $sale->created_at->format('Y-m-d'),
                'amount' => $sale->total_amount,
            ];
        });

        $stockInData = $stockIns->map(function ($stock) {
            return [
                'date' => $stock->created_at->format('Y-m-d'),
                'quantity' => $stock->quantity,
            ];
        });

        $stockOutData = $stockOuts->map(function ($stock) {
            return [
                'date' => $stock->created_at->format('Y-m-d'),
                'quantity' => $stock->quantity,
            ];
        });

        // Pass all data to the view
        return view('admin.reports.index', compact(
            'purchases', 'purchaseReturns', 'sales', 'salesReturns',
            'netPurchases', 'netSales', 'profit', 'totalStockIn', 'totalStockOut', 'currentStock',
            'purchaseData', 'salesData', 'stockInData', 'stockOutData'
        ));
    }
}
