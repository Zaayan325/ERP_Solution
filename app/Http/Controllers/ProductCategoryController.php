<?php

namespace App\Http\Controllers;

use App\Models\Product_Category;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = Product_Category::all();
        return view('product_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('product_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_categories',
        ]);

        Product_Category::create($request->all());

        return redirect()->route('product_categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Product_Category $productCategory)
    {
        return view('product_categories.edit', compact('productCategory'));
    }

    public function update(Request $request, Product_Category $productCategory)
    {
        $request->validate([
            'name' => 'required|unique:product_categories,name,' . $productCategory->id,
        ]);

        $productCategory->update($request->all());

        return redirect()->route('product_categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Product_Category $productCategory)
    {
        $productCategory->delete();

        return redirect()->route('product_categories.index')->with('success', 'Category deleted successfully.');
    }
}
