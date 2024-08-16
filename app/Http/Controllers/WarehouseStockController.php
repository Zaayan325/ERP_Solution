<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseStock;
use App\Models\Product;
use App\Models\WarehouseStockOut;
use App\Models\WarehouseStockAdjustment;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use App\Imports\WarehouseStockImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WarehouseStockExport;


class WarehouseStockController extends Controller
{
    public function index()
    {
        $warehouseStocks = WarehouseStock::with('warehouse','product')->get();
        return view('admin.warehouse_stock.index', compact('warehouseStocks'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('admin.warehouse_stock.create', compact('warehouses','products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'batch_number' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
        ]);
    
        $stock = WarehouseStock::firstOrCreate([
            'warehouse_id' => $request->warehouse_id,
            'product_id' => $request->product_id,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
        ],
        ['quantity' => 0]    
    );
        
        // Update the stock quantity
        $stock->quantity += $request->quantity;
        $stock->save();

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock added successfully.');
    }

    public function edit(WarehouseStock $warehouseStock)
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('admin.warehouse_stock.edit', compact('warehouseStock', 'warehouses','products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'batch_number' => 'nullable|string|max:50',
            'expiry_date' => 'nullable|date',
        ]);
    
        $stock = WarehouseStock::findOrFail($id);
        $stock->update([
            'quantity' => $request->quantity,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock updated successfully.');
    }

    public function destroy(WarehouseStock $warehouseStock)
    {
        $warehouseStock->delete();

        return redirect()->route('warehouse_stock.index')->with('success', 'Stock deleted successfully.');
    }

    //Warehouse Stock Out


    public function createStockOut()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('admin.warehouse_stock.stock_out_create', compact('warehouses', 'products'));
    }

    public function stockOut(Request $request)
{
    $request->validate([
        'warehouse_id' => 'required|exists:warehouses,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'batch_number' => 'nullable|string|max:50',
        'reason' => 'nullable|string|max:255',
    ]);

    $warehouseStock = WarehouseStock::where('warehouse_id', $request->warehouse_id)
                        ->where('product_id', $request->product_id)
                        ->first();

    if (!$warehouseStock) {
        return response()->json(['success' => false, 'message' => 'No stock found for this product in the warehouse.']);
    }

    if ($warehouseStock->quantity < $request->quantity) {
        return response()->json(['success' => false, 'message' => 'Not enough stock available.']);
    }

    // Reduce the stock quantity
    $warehouseStock->quantity -= $request->quantity;
    $warehouseStock->save();

    // Log the stock out transaction
    $stockOut = WarehouseStockOut::create([
        'warehouse_id' => $request->warehouse_id,
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'batch_number' => $request->batch_number,
        'reason' => $request->reason,
    ]);

    return redirect()->route('warehouse_stock.adjustments')->with('success', 'Stock deleted successfully.');
}


    //Current Stock Functnality
    public function getCurrentStock($warehouseId, $productId)
    {
        $stockIn = WarehouseStock::where('warehouse_id', $warehouseId)
                    ->where('product_id', $productId)
                    ->sum('quantity');
    
        $stockOut = WarehouseStockOut::where('warehouse_id', $warehouseId)
                    ->where('product_id', $productId)
                    ->sum('quantity');
    
        $currentStock = $stockIn - $stockOut;
    
        return $currentStock;
    }
    

//stock Adjust

public function adjustStock(Request $request)
{
    $request->validate([
        'warehouse_id' => 'required|exists:warehouses,id',
        'product_id' => 'required|exists:products,id',
        'adjustment_quantity' => 'required|integer',
        'reason' => 'nullable|string|max:255',
    ]);

    $warehouseStock = WarehouseStock::where('warehouse_id', $request->warehouse_id)
                        ->where('product_id', $request->product_id)
                        ->first();

    if (!$warehouseStock) {
        return response()->json(['success' => false, 'message' => 'No stock found for this product in the warehouse.']);
    }

    // Adjust the stock quantity
    $warehouseStock->quantity += $request->adjustment_quantity;
    $warehouseStock->save();

    // Log the adjustment
    $adjustment = WarehouseStockAdjustment::create([
        'warehouse_id' => $request->warehouse_id,
        'product_id' => $request->product_id,
        'adjustment_quantity' => $request->adjustment_quantity,
        'reason' => $request->reason,
    ]);

    return response()->json(['success' => true, 'adjustment' => $adjustment]);
}

//Import Stock
public function importStock(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx',
    ]);

    Excel::import(new WarehouseStockImport, $request->file('file'));

    return redirect()->back()->with('success', 'Stock imported successfully.');
}

//export stock
public function exportStock(Request $request)
{
    return Excel::download(new WarehouseStockExport, 'warehouse_stock.xlsx');
}

//filters
public function showStock(Request $request)
{
    $query = WarehouseStock::with(['product.category', 'product.brand', 'product.unit']);

    if ($request->filled('product_id')) {
        $query->where('product_id', $request->product_id);
    }

    if ($request->filled('category_id')) {
        $query->whereHas('product.category', function($q) use ($request) {
            $q->where('id', $request->category_id);
        });
    }

    if ($request->filled('brand_id')) {
        $query->whereHas('product.brand', function($q) use ($request) {
            $q->where('id', $request->brand_id);
        });
    }

    if ($request->filled('batch_number')) {
        $query->where('batch_number', $request->batch_number);
    }

    if ($request->filled('expiry_date')) {
        $query->where('expiry_date', $request->expiry_date);
    }

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }

    $stocks = $query->paginate(10);

    return view('admin.warehouse.stock', compact('stocks'));
}

    public function showAdjustments()
    {
        $adjustments = WarehouseStockAdjustment::with('warehouse', 'product')->paginate(10);
        return view('admin.warehouse_stock.adjustments', compact('adjustments'));
    }

    public function showCurrentStock()
    {
        $stocks = WarehouseStock::with('warehouse', 'product')->paginate(10);
        return view('admin.warehouse_stock.current_stock', compact('stocks'));
    }

}
