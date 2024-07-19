<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Http\Request;

class PurchaseItemController extends Controller
{
    public function index()
    {
        $purchaseItems = PurchaseItem::with('purchase', 'product')->get();
        return view('admin.purchase_items.index', compact('purchaseItems'));
    }

    public function create()
    {
        $purchases = Purchase::all();
        $products = Product::all();
        return view('admin.purchase_items.create', compact('purchases', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        PurchaseItem::create([
            'purchase_id' => $request->purchase_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
        ]);

        return redirect()->route('purchase_items.index')->with('success', 'Purchase Item created successfully.');
    }

    public function edit(PurchaseItem $purchaseItem)
    {
        $purchases = Purchase::all();
        $products = Product::all();
        return view('admin.purchase_items.edit', compact('purchaseItem', 'purchases', 'products'));
    }

    public function update(Request $request, PurchaseItem $purchaseItem)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $purchaseItem->update([
            'purchase_id' => $request->purchase_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
        ]);

        return redirect()->route('purchase_items.index')->with('success', 'Purchase Item updated successfully.');
    }

    public function destroy(PurchaseItem $purchaseItem)
    {
        $purchaseItem->delete();

        return redirect()->route('purchase_items.index')->with('success', 'Purchase Item deleted successfully.');
    }

}
