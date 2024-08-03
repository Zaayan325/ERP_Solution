<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesItem;
use App\Models\SalesReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer', 'items.product.brand')->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::with('brand')->get();
        $customers = Customer::all();
        return view('admin.sales.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $totalAmount = 0;

            $sale = Sale::create([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'total_amount' => 0, // temporary value
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total = $item['price'] * $item['quantity'];
                $totalAmount += $total;

                SalesItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $total,
                ]);

                // Deduct product stock
                $product->update(['stock' => $product->stock - $item['quantity']]);
            }

            $sale->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }

    public function edit(Sale $sale)
    {
        $products = Product::with('brand')->get();
        $customers = Customer::all();
        $sale->load('items.product.brand');
        return view('admin.sales.edit', compact('sale', 'products', 'customers'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $sale) {
            $totalAmount = 0;

            // Reverse the stock for the existing items
            foreach ($sale->items as $item) {
                $product = Product::findOrFail($item->product_id);
                $product->update(['stock' => $product->stock + $item->quantity]);
                $item->delete();
            }

            // Update the sale
            $sale->update([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
            ]);

            // Add the new items
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total = $item['price'] * $item['quantity'];
                $totalAmount += $total;

                SalesItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $total,
                ]);

                // Deduct product stock
                $product->update(['stock' => $product->stock - $item['quantity']]);
            }

            $sale->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function show(Sale $sale)
    {
        $sale->load('customer', 'items.product.brand');
        return view('admin.sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            // Reverse the stock for the existing items
            foreach ($sale->items as $item) {
                $product = Product::findOrFail($item->product_id);
                $product->update(['stock' => $product->stock + $item->quantity]);
                $item->delete();
            }

            $sale->delete();
        });

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
