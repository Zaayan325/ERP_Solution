<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock_Category;

class StockCategoryController extends Controller
{
    public function index()
    {
        $stockCategories = Stock_Category::all();
        return view('admin.stock_categories.index', compact('stockCategories'));
    }

    public function create()
    {
        return view('admin.stock_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:stock_categories']);

        Stock_Category::create($request->all());

        return redirect()->route('admin.stock_categories.index')->with('success', 'Stock Category created successfully.');
    }

    public function edit(Stock_Category $stockCategory)
    {
        return view('admin.stock_categories.edit', compact('stockCategory'));
    }

    public function update(Request $request, Stock_Category $stockCategory)
    {
        $request->validate(['name' => 'required|unique:stock_categories,name,' . $stockCategory->id]);

        $stockCategory->update($request->all());

        return redirect()->route('admin.stock_categories.index')->with('success', 'Stock Category updated successfully.');
    }

    public function destroy(Stock_Category $stockCategory)
    {
        $stockCategory->delete();

        return redirect()->route('admin.stock_categories.index')->with('success', 'Stock Category deleted successfully.');
    }
}
