<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::paginate(10); // Pagination with 10 items per page
        return response()->json([
            'categories' => $categories->items(),
            'pagination' => [
                'total' => $categories->total(),
                'per_page' => $categories->perPage(),
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'from' => $categories->firstItem(),
                'to' => $categories->lastItem()
            ]
        ]);
    }


    public function store(Request $request)
{
    try {
        // Validate the request
        $request->validate(['name' => 'required|unique:product_categories,name']);

        // Create the category
        $category = ProductCategory::create(['name' => $request->name]);

        // Log the creation
        Log::info('Category created successfully', ['category' => $category->toArray()]);

        // Return a JSON response
        return response()->json(['success' => true, 'category' => $category]);

    } catch (\Exception $e) {
        // Log the error
        Log::error('Error adding category: ' . $e->getMessage());

        // Return a JSON response with an error message
        return response()->json(['success' => false, 'message' => 'Failed to add category. Please try again later.'], 500);
    }
}


    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:product_categories,name,' . $id]);
        $category = ProductCategory::findOrFail($id);
        $category->update(['name' => $request->name]);
        return response()->json(['success' => true, 'category' => $category]);
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();
        return response()->json(['success' => true]);
    }
}
