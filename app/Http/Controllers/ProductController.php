<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_Category;
use App\Models\Brand;
use App\Models\UOM;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'uom'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Product_Category::all();
        $brands = Brand::all();
        $uoms = Uom::all();
        return view('products.create', compact('categories', 'brands', 'uoms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:product_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'uom_id' => 'required|exists:uoms,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Product_Category::all();
        $brands = Brand::all();
        $uoms = Uom::all();
        return view('products.edit', compact('product', 'categories', 'brands', 'uoms'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:product_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'uom_id' => 'required|exists:uoms,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
