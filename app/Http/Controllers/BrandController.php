<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:brands,name']);
        $brand = Brand::create(['name' => $request->name]);
        return response()->json(['success' => true, 'brand' => $brand]);
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:brands,name,' . $id]);
        $brand = Brand::findOrFail($id);
        $brand->update(['name' => $request->name]);
        return response()->json(['success' => true, 'brand' => $brand]);
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(['success' => true]);
    }
}
