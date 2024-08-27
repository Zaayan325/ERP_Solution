<?php   

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesItem;
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
        'customer_id' => 'nullable|exists:customers,id',
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    try {
        // Start a transaction
        DB::beginTransaction();

        // Create the sale
        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'total_amount' => 0, // Placeholder for now
        ]);

        $totalAmount = 0;

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

        // Update the sale with the correct total amount
        $sale->update(['total_amount' => $totalAmount]);

        // Commit the transaction
        DB::commit();

        // Redirect to the sale's show route
        return redirect()->route('sales.show', $sale->id)->with('success', 'Sale created successfully.');

    } catch (\Exception $e) {
        // Rollback the transaction in case of error
        DB::rollBack();
        return redirect()->route('sales.index')->with('error', 'Failed to create sale.');
    }
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
