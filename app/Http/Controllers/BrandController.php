<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


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
    try {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'logo' => 'nullable|image|max:2048', // Image validation
            'ntn_number' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $logoPath = $request->file('logo') ? $request->file('logo')->store('uploads', 'public') : null;

        $brand = Brand::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'ntn_number' => $request->ntn_number,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return response()->json(['success' => true, 'brand' => $brand]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}


public function update(Request $request, $id)
{
    // Force JSON response for validation errors
    $request->headers->set('Accept', 'application/json');

    // Validate the request data
    $request->validate([
        'name' => 'required|unique:brands,name,' . $id,
        'logo' => 'nullable|image|max:2048',
        'ntn_number' => 'nullable|string|max:20',
        'phone_number' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:255',
    ]);

    try {
        // Find the brand
        $brand = Brand::findOrFail($id);

        // Start a transaction
        DB::beginTransaction();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists
            if ($brand->logo && Storage::disk('public')->exists($brand->logo)) {
                Storage::disk('public')->delete($brand->logo);
            }

            // Save new logo
            $logoPath = $request->file('logo')->store('uploads', 'public');
            $brand->logo = $logoPath;
        }

        // Update other brand details
        $brand->update([
            'name' => $request->name,
            'ntn_number' => $request->ntn_number,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // Commit the transaction
        DB::commit();

        // Return success response
        return response()->json(['success' => true, 'brand' => $brand]);
    } catch (\Exception $e) {
        // Rollback in case of failure
        DB::rollBack();

        // Log the error
        Log::error('Brand update failed: ' . $e->getMessage());

        // Return failure response
        return response()->json(['success' => false, 'message' => 'Failed to update brand.'], 500);
    }
}

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return response()->json(['success' => true]);
    }
}
