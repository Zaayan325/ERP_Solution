<?php

namespace App\Http\Controllers;

use App\Models\Product_Category;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = Product_Category::all();
        return view('admin.product_categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Product_Category::all();
        return view('admin.product_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:product_categories,name']);
        $category = Product_Category::create(['name' => $request->name]);
        return response()->json(['success' => true, 'category' => $category]);
    }

    public function edit(Product_Category $productCategory)
    {
        return view('admin.product_categories.edit', compact('productCategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:product_categories,name,' . $id]);
        $category = Product_Category::findOrFail($id);
        $category->update(['name' => $request->name]);
        return response()->json(['success' => true, 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = Product_Category::findOrFail($id);
        $category->delete();
        return response()->json(['success' => true]);
    }
}
