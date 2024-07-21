<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseStock;
use Illuminate\Http\Request;

class WarehouseStockController extends Controller
{
    public function index()
    {
        $warehouseStocks = WarehouseStock::with('warehouse')->get();
        return view('admin.warehouse_stock.index', compact('warehouseStocks'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        return view('admin.warehouse_stock.create', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_name' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        WarehouseStock::create([
            'warehouse_id' => $request->warehouse_id,
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock added successfully.');
    }

    public function edit(WarehouseStock $warehouseStock)
    {
        $warehouses = Warehouse::all();
        return view('admin.warehouse_stock.edit', compact('warehouseStock', 'warehouses'));
    }

    public function update(Request $request, WarehouseStock $warehouseStock)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_name' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        $warehouseStock->update($request->all());

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock updated successfully.');
    }

    public function destroy(WarehouseStock $warehouseStock)
    {
        $warehouseStock->delete();

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock deleted successfully.');
    }
}
