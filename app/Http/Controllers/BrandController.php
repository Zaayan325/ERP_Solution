<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(10); // 10 items per page
        return response()->json([
            'brands' => $brands->items(),
            'pagination' => [
                'total' => $brands->total(),
                'per_page' => $brands->perPage(),
                'current_page' => $brands->currentPage(),
                'last_page' => $brands->lastPage(),
                'from' => $brands->firstItem(),
                'to' => $brands->lastItem()
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:brands,name']);
        $brand = Brand::create(['name' => $request->name]);
        return response()->json(['success' => true, 'brand' => $brand]);
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
