<?php

namespace App\Http\Controllers;

use App\Models\PurchaseReturn;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $purchaseReturns = PurchaseReturn::with('supplier', 'product.brand')->paginate(10);
        return view('admin.purchase_returns.index', compact('purchaseReturns'));
    }

    public function create()
    {
        $products = Product::with('brand')->get();
        $suppliers = Supplier::all();
        return view('admin.purchase_returns.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);
            $total = $request->price * $request->quantity;

            PurchaseReturn::create([
                'supplier_id' => $request->supplier_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $total,
                'date' => $request->date,
            ]);

            // Decrease product stock
            $product->update(['stock' => $product->stock - $request->quantity]);
        });

        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return processed successfully.');
    }

    public function show(PurchaseReturn $purchaseReturn)
    {
        return view('admin.purchase_returns.show', compact('purchaseReturn'));
    }

    public function edit(PurchaseReturn $purchaseReturn)
    {
        $products = Product::with('brand')->get();
        $suppliers = Supplier::all();
        return view('admin.purchase_returns.edit', compact('purchaseReturn', 'products', 'suppliers'));
    }

    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $purchaseReturn) {
            // Reverse the stock changes from the original return
            $product = Product::findOrFail($purchaseReturn->product_id);
            $product->update(['stock' => $product->stock + $purchaseReturn->quantity]);

            // Update the purchase return
            $total = $request->price * $request->quantity;
            $purchaseReturn->update([
                'supplier_id' => $request->supplier_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $total,
                'date' => $request->date,
            ]);

            // Adjust the product stock for the updated return
            $product = Product::findOrFail($request->product_id);
            $product->update(['stock' => $product->stock - $request->quantity]);
        });

        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return updated successfully.');
    }

    public function destroy(PurchaseReturn $purchaseReturn)
    {
        DB::transaction(function () use ($purchaseReturn) {
            // Reverse the stock changes
            $product = Product::findOrFail($purchaseReturn->product_id);
            $product->update(['stock' => $product->stock + $purchaseReturn->quantity]);

            $purchaseReturn->delete();
        });

        return redirect()->route('purchase_returns.index')->with('success', 'Purchase return deleted successfully.');
    }
}
