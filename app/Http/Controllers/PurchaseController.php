<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->paginate(10);
        return view('admin.purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::with('brand')->get();
        $suppliers = Supplier::all();
        return view('admin.purchases.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;

            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'date' => $request->date,
                'total_amount' => 0, // temporary value
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total = $item['price'] * $item['quantity'];
                $totalAmount += $total;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $total,
                ]);

                // Increase product stock
                $product->update(['stock' => $product->stock + $item['quantity']]);
            }

            $purchase->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase created successfully.');
    }

    public function edit(Purchase $purchase)
    {
        $products = Product::with('brand')->get();
        $suppliers = Supplier::all();
        $purchase->load('items.product');
        return view('admin.purchases.edit', compact('purchase', 'products', 'suppliers'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $purchase) {
            $totalAmount = 0;

            // Reverse the stock for the existing items
            foreach ($purchase->items as $item) {
                $product = Product::findOrFail($item->product_id);
                $product->update(['stock' => $product->stock - $item->quantity]);
                $item->delete();
            }

            // Update the purchase
            $purchase->update([
                'supplier_id' => $request->supplier_id,
                'date' => $request->date,
            ]);

            // Add the new items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total = $item['price'] * $item['quantity'];
                $totalAmount += $total;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $total,
                ]);

                // Increase product stock
                $product->update(['stock' => $product->stock + $item['quantity']]);
            }

            $purchase->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('supplier', 'items.product.brand');
        return view('admin.purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            // Reverse the stock for the existing items
            foreach ($purchase->items as $item) {
                $product = Product::findOrFail($item->product_id);
                $product->update(['stock' => $product->stock - $item->quantity]);
                $item->delete();
            }

            $purchase->delete();
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}
