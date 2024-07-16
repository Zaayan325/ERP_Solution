<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseStock;
use Illuminate\Http\Request;

class WarehouseStockController extends Controller
{
    public function index(Warehouse $warehouse)
    {
        $stocks = $warehouse->stocks;
        return view('admin.warehouse_stock.index', compact('warehouse', 'stocks'));
    }

    public function create(Warehouse $warehouse)
    {
        return view('admin.warehouse_stock.create', compact('warehouse'));
    }

    public function store(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_name' => 'required',
            'quantity' => 'required|integer',
        ]);

        $warehouse->stocks()->create($request->all());

        return redirect()->route('warehouse_stock.index', $warehouse)->with('success', 'Stock added successfully.');
    }

    public function edit(Warehouse $warehouse, WarehouseStock $stock)
    {
        return view('admin.warehouse_stock.edit', compact('warehouse', 'stock'));
    }

    public function update(Request $request, Warehouse $warehouse, WarehouseStock $stock)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_name' => 'required',
            'quantity' => 'required|integer',
        ]);

        $stock->update($request->all());

        return redirect()->route('warehouse_stock.index', $warehouse)->with('success', 'Stock updated successfully.');
    }

    public function destroy(Warehouse $warehouse, WarehouseStock $stock)
    {
        $stock->delete();

        return redirect()->route('warehouse_stock.index', $warehouse)->with('success', 'Stock deleted successfully.');
    }
}
