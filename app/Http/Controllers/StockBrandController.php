<?php

namespace App\Http\Controllers;

use App\Models\Stock_Brand;
use Illuminate\Http\Request;

class StockBrandController extends Controller
{
    public function index()
    {
        $stockBrands = Stock_Brand::all();
        return view('admin.stock_brands.index', compact('stockBrands'));
    }

    public function create()
    {
        return view('admin.stock_brands.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:stock_brands']);

        Stock_Brand::create($request->all());

        return redirect()->route('stock_brands.index')->with('success', 'Stock Brand created successfully.');
    }

    public function edit(Stock_Brand $stockBrand)
    {
        return view('admin.stock_brands.edit', compact('stockBrand'));
    }

    public function update(Request $request, Stock_Brand $stockBrand)
    {
        $request->validate(['name' => 'required|unique:stock_brands,name,' . $stockBrand->id]);

        $stockBrand->update($request->all());

        return redirect()->route('stock_brands.index')->with('success', 'Stock Brand updated successfully.');
    }

    public function destroy(Stock_Brand $stockBrand)
    {
        $stockBrand->delete();

        return redirect()->route('stock_brands.index')->with('success', 'Stock Brand deleted successfully.');
    }
}
