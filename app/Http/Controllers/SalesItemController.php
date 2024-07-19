<?php

namespace App\Http\Controllers;

use App\Models\SalesItem;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SalesItemController extends Controller
{
    public function index()
    {
        $salesItems = SalesItem::with('sale', 'product')->get();
        return view('admin.sales_items.index', compact('salesItems'));
    }

    public function create()
    {
        $sales = Sale::all();
        $products = Product::all();
        return view('admin.sales_items.create', compact('sales', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        SalesItem::create([
            'sale_id' => $request->sale_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
        ]);

        return redirect()->route('sales_items.index')->with('success', 'Sales Item created successfully.');
    }

    public function edit(SalesItem $salesItem)
    {
        $sales = Sale::all();
        $products = Product::all();
        return view('admin.sales_items.edit', compact('salesItem', 'sales', 'products'));
    }

    public function update(Request $request, SalesItem $salesItem)
    {
        $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $salesItem->update([
            'sale_id' => $request->sale_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
        ]);

        return redirect()->route('sales_items.index')->with('success', 'Sales Item updated successfully.');
    }

    public function destroy(SalesItem $salesItem)
    {
        $salesItem->delete();

        return redirect()->route('sales_items.index')->with('success', 'Sales Item deleted successfully.');
    }
}
