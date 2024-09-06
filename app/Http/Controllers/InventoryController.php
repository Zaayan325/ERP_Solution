<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\InventoryAdjustment;


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

    public function show()
    {
    $inventory = Product::select('products.id', 'products.name', DB::raw('SUM(inventory.quantity) as total_quantity'))
            ->leftJoin('inventory_adjustments', 'products.id', '=', 'inventory_adjustments.product_id')
            ->groupBy('products.id')
            ->get();

        return view('admin.inventory.current', compact('inventory'));
    }

    // Create adjustment form
    public function createAdjustStock()
    {
        $products = Product::all();
        return view('admin.inventory.adjust_stock_create', compact('products'));
    }

    // Store the adjustment
    public function adjustStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'adjustment_quantity' => 'required|integer',
            'reason' => 'nullable|string|max:255',
        ]);

        // Log the adjustment
        InventoryAdjustment::create([
            'product_id' => $request->product_id,
            'adjustment_quantity' => $request->adjustment_quantity,
            'reason' => $request->reason,
        ]);

        return redirect()->route('inventory.current')->with('success', 'Inventory adjusted successfully.');
    }

    // Show all adjustments
    public function showAdjustments()
    {
        $adjustments = InventoryAdjustment::with('product')->paginate(10);
        return view('admin.inventory.adjustments', compact('adjustments'));
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')->with('success', 'Inventory deleted successfully.');
    }
}