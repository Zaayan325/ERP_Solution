<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
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
        $productCategories = ProductCategory::all();
        $brands = Brand::all();
        $uoms = Uom::all();
        return view('admin.products.create', compact('productCategories', 'brands', 'uoms'));
    }

    public function store(Request $request)
    {
        Log::info('Request Data: ', $request->all());

        $request->validate([
            'name' => 'required',
            'model_no'=> 'nullable|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'uom_id' => 'required|exists:uoms,id',
        ]);

        Product::create([
            'name' => $request->name,
            'model_no' => $request->model_no,
            'product_category_id' => $request->category_id, // Ensure this line is correct
            'brand_id' => $request->brand_id,
            'uom_id' => $request->uom_id,
        ]);

        if ($request->input('submit_action') === 'submit_and_add_another') {
            return redirect()->route('products.create')->with('success', 'Product created successfully. You can add another.');
        }
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $productCategories = ProductCategory::all();
        $brands = Brand::all();
        $uoms = Uom::all();
        return view('admin.products.edit', compact('product', 'productCategories', 'brands', 'uoms'));
    }

    public function update(Request $request, Product $product)
{
    Log::info('Update Request Data: ', $request->all());

    $request->validate([
        'name' => 'required',
        'model_no' => 'nullable|string|max:255',
        'product_category_id' => 'required|exists:product_categories,id',
        'brand_id' => 'required|exists:brands,id',
        'uom_id' => 'required|exists:uoms,id',
    ]);

    Log::info('Before Update: ', $product->toArray());

    $product->update([
        'name' => $request->name,
        'model_no' => $request->model_no,
        'product_category_id' => $request->product_category_id,
        'brand_id' => $request->brand_id,
        'uom_id' => $request->uom_id,
    ]);

    Log::info('After Update: ', $product->toArray());

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
