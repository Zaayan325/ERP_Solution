<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Sale;
use App\Models\SalesReturn;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier', 'items.product.brand')->get();
        $purchaseReturns = PurchaseReturn::with('purchase.supplier', 'product.brand')->get();
        $sales = Sale::with('customer', 'items.product.brand')->get();
        $salesReturns = SalesReturn::with('sale.customer', 'product.brand')->get();
        $products = Product::with('brand')->get();

        return view('admin.reports.index', compact('purchases', 'purchaseReturns', 'sales', 'salesReturns', 'products'));
    }
}
