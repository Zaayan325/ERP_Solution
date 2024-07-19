<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with('product')->get();
        return view('admin.inventory.index', compact('inventory'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.inventory.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'reorder_level' => 'required|integer',
        ]);

        Inventory::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function edit(Inventory $inventory)
    {
        $products = Product::all();
        return view('admin.inventory.edit', compact('inventory', 'products'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'reorder_level' => 'required|integer',
        ]);

        $inventory->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Inventory updated successfully.');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventory deleted successfully.');
    }
}