<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_Category;
use App\Models\Brand;
use App\Models\UOM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand', 'uom'])->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $productCategories = Product_Category::all();
        $brands = Brand::all();
        $uoms = Uom::all();
        return view('admin.products.create', compact('productCategories', 'brands', 'uoms'));
    }

    public function store(Request $request)
{
    Log::info('Request Data: ', $request->all());

    $request->validate([
        'name' => 'required',
        'product_category_id' => 'required|exists:product_categories,id',
        'brand_id' => 'required|exists:brands,id',
        'uom_id' => 'required|exists:uoms,id',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
    ]);

    Product::create([
        'name' => $request->name,
        'product_category_id' => $request->product_category_id,
        'brand_id' => $request->brand_id,
        'uom_id' => $request->uom_id,
        'price' => $request->price,
        'stock' => $request->stock,
    ]);

    return redirect()->route('products.index')->with('success', 'Product created successfully.');
}
public function edit(Product $product)
    {
        $productCategories = Product_Category::all();
        $brands = Brand::all();
        $uoms = Uom::all();
        return view('admin.products.edit', compact('product', 'productCategories', 'brands', 'uoms'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'product_category_id' => 'required|exists:product_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'uom_id' => 'required|exists:uoms,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product->update([
            'name' => $request->name,
            'product_category_id' => $request->product_category_id,
            'brand_id' => $request->brand_id,
            'uom_id' => $request->uom_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
