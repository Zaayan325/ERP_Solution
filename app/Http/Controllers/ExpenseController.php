<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // Show the list of expenses
    public function index()
    {
        $expenses = Expense::with('category')->paginate(10);
        return view('admin.expenses.index', compact('expenses'));
    }

    // Show form to create a new expense
    public function create()
    {
        $categories = ExpenseCategory::all(); // Fetch all categories
        return view('admin.expenses.create', compact('categories'));
    }

    // Store the new expense
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    // Show form to edit an existing expense
    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::all();
        return view('admin.expenses.edit', compact('expense', 'categories'));
    }

    // Update the expense
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'category_id' => 'required|exists:expense_categories,id',
            'amount' => 'required|numeric|min:0.01',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    // Delete an expense
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
