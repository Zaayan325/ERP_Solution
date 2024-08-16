<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class WarehouseStockController extends Controller
{
    public function index()
    {
        $warehouseStocks = WarehouseStock::with('warehouse','product')->get();
        return view('admin.warehouse_stock.index', compact('warehouseStocks'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('admin.warehouse_stock.create', compact('warehouses','products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'batch_number' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
        ]);
    
        $stock = WarehouseStock::create([
            'warehouse_id' => $request->warehouse_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock added successfully.');
    }

    public function edit(WarehouseStock $warehouseStock)
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('admin.warehouse_stock.edit', compact('warehouseStock', 'warehouses','products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'batch_number' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
        ]);
    
        $stock = WarehouseStock::findOrFail($id);
        $stock->update([
            'quantity' => $request->quantity,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock updated successfully.');
    }

    public function destroy(WarehouseStock $warehouseStock)
    {
        $warehouseStock->delete();

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock deleted successfully.');
    }
}
