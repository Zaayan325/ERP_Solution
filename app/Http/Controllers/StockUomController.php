<?php

namespace App\Http\Controllers;

use App\Models\Stock_UOM;
use Illuminate\Http\Request;

class StockUomController extends Controller
{
    public function index()
    {
        $stockUoms = Stock_Uom::all();
        return view('admin.stock_uoms.index', compact('stockUoms'));
    }

    public function create()
    {
        return view('admin.stock_uoms.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:stock_uoms']);

        Stock_Uom::create($request->all());

        return redirect()->route('stock_uoms.index')->with('success', 'Stock UOM created successfully.');
    }

    public function edit(Stock_Uom $stockUom)
    {
        return view('admin.stock_uoms.edit', compact('stockUom'));
    }

    public function update(Request $request, Stock_Uom $stockUom)
    {
        $request->validate(['name' => 'required|unique:stock_uoms,name,' . $stockUom->id]);

        $stockUom->update($request->all());

        return redirect()->route('stock_uoms.index')->with('success', 'Stock UOM updated successfully.');
    }

    public function destroy(Stock_Uom $stockUom)
    {
        $stockUom->delete();

        return redirect()->route('stock_uoms.index')->with('success', 'Stock UOM deleted successfully.');
    }
}
