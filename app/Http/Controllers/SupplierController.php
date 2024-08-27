<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::paginate(10); // Pagination with 10 items per page
        return response()->json([
            'suppliers' => $suppliers->items(),
            'pagination' => [
                'total' => $suppliers->total(),
                'per_page' => $suppliers->perPage(),
                'current_page' => $suppliers->currentPage(),
                'last_page' => $suppliers->lastPage(),
                'from' => $suppliers->firstItem(),
                'to' => $suppliers->lastItem(),
            ]
        ]);
    }


    public function store(Request $request)
{
    Log::info('Store Supplier Request:', $request->all());

    try {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email|unique:suppliers',
            'phone' => 'required',  // This is causing the 422 error when null
            'address' => 'nullable',
        ]);

        // Create the supplier
        $supplier = Supplier::create($validated);

        // Return success response
        return response()->json(['success' => true, 'supplier' => $supplier]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Return validation errors
        return response()->json(['success' => false, 'errors' => $e->errors()], 422);
    }
}

    
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|unique:suppliers,name,' . $supplier->id,
            'email' => 'nullable|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required',
            'address' => 'nullable',
        ]);

        $supplier->update($request->all());

        return response()->json(['success' => true, 'supplier' => $supplier]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['success' => true]);
    }
}
