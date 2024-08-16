<?php

namespace App\Http\Controllers;

use App\Models\SalesReturn;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesReturnController extends Controller
{
    public function index()
    {
        $salesReturns = SalesReturn::with('customer', 'product.brand')->paginate(10);
        return view('admin.sales_returns.index', compact('salesReturns'));
    }

    public function create()
    {
        $products = Product::with('brand')->get();
        
        // Retrieve all customers
        $customers = Customer::all();
        
        // Pass the variables to the view
        return view('admin.sales_returns.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);
            $total = $request->price * $request->quantity;

            SalesReturn::create([
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $total,
            ]);

            // Increase product stock
            $product->update(['stock' => $product->stock + $request->quantity]);
        });

        return redirect()->route('sales_returns.index')->with('success', 'Sales return processed successfully.');
    }

    public function show(SalesReturn $salesReturn)
    {
        return view('admin.sales_returns.show', compact('salesReturn'));
    }

    public function edit(SalesReturn $salesReturn)
    {
        $products = Product::with('brand')->get();
        $customers = Customer::all();
        return view('admin.sales_returns.edit', compact('salesReturn', 'products', 'customers'));
    }

    public function update(Request $request, SalesReturn $salesReturn)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $salesReturn) {
            // Reverse the stock changes from the original return
            $product = Product::findOrFail($salesReturn->product_id);
            $product->update(['stock' => $product->stock - $salesReturn->quantity]);

            // Update the sales return
            $total = $request->price * $request->quantity;
            $salesReturn->update([
                'customer_id' => $request->customer_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'total' => $total,
            ]);

            // Adjust the product stock for the updated return
            $product = Product::findOrFail($request->product_id);
            $product->update(['stock' => $product->stock + $request->quantity]);
        });

        return redirect()->route('sales_returns.index')->with('success', 'Sales return updated successfully.');
    }

    public function destroy(SalesReturn $salesReturn)
    {
        DB::transaction(function () use ($salesReturn) {
            // Reverse the stock changes
            $product = Product::findOrFail($salesReturn->product_id);
            $product->update(['stock' => $product->stock - $salesReturn->quantity]);

            $salesReturn->delete();
        });

        return redirect()->route('sales_returns.index')->with('success', 'Sales return deleted successfully.');
    }
}
