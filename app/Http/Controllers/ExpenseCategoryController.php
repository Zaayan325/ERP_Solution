<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    // Store a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:expense_categories,name',
        ]);

        $category = ExpenseCategory::create(['name' => $request->name]);

        return response()->json(['success' => true, 'category' => $category]);
    }

    // Fetch all categories (for pagination and existing category listing)
    public function index(Request $request)
    {
        $categories = ExpenseCategory::paginate(5); // Paginate to 5 per page
        return response()->json([
            'categories' => $categories->items(),
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
            ]
        ]);
    }
}
