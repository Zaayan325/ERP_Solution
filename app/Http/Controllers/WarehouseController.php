<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('admin.warehouse.index', compact('warehouses'));
    }

    public function create()
    {
        return view('admin.warehouse.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:warehouses',
            'location' => 'required',
        ]);

        Warehouse::create($request->all());

        return redirect()->route('warehouses.index')->with('success', 'Warehouse created successfully.');
    }

    public function show(Warehouse $warehouse)
    {
        return view('admin.warehouse.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('admin.warehouse.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|unique:warehouses,name,' . $warehouse->id,
            'location' => 'required',
        ]);

        $warehouse->update($request->all());

        return redirect()->route('warehouses.index')->with('success', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();

        return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted successfully.');
    }
}
