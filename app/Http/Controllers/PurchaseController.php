<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier', 'items.product.brand')->paginate(10);
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
            'supplier_id' => 'nullable|exists:suppliers,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            // Start a transaction
            DB::beginTransaction();

            // Create the purchase
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'total_amount' => 0, // Placeholder for now
            ]);

            $totalAmount = 0;

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

                // No stock increment logic here, as requested
            }

            // Update the purchase with the correct total amount
            $purchase->update(['total_amount' => $totalAmount]);

            // Commit the transaction
            DB::commit();

            // Redirect to the purchase's show route
            return redirect()->route('purchases.index', $purchase->id)->with('success', 'Purchase created successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            return redirect()->route('purchases.index')->with('error', 'Failed to create purchase.');
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('supplier', 'items.product.brand');
        return view('admin.purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            // No stock reversal logic here, as requested
            $purchase->items()->delete();
            $purchase->delete();
        });

        return redirect()->route('purchases.index')->with('success', 'Purchase deleted successfully.');
    }
}
