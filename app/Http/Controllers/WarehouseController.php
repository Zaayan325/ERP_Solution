<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::paginate(10); // Pagination with 10 items per page
        return response()->json([
            'warehouses' => $warehouses->items(),
            'pagination' => [
                'total' => $warehouses->total(),
                'per_page' => $warehouses->perPage(),
                'current_page' => $warehouses->currentPage(),
                'last_page' => $warehouses->lastPage(),
                'from' => $warehouses->firstItem(),
                'to' => $warehouses->lastItem()
            ]
        ]);
    }


    public function store(Request $request)
    {
        // Validate the request
    $request->validate([
        'name' => 'required',
        'location' => 'required'
    ]);

    // Create the warehouse
    $warehouse = Warehouse::create($request->all());

    // Return a JSON response
    return response()->json(['success' => true, 'warehouse' => $warehouse]);

    }


    public function update(Request $request, Warehouse $warehouse)
{
    $request->validate([
        'name' => 'required|unique:warehouses,name,' . $warehouse->id,
        'location' => 'required',
    ]);

    // Update the warehouse
    $warehouse->update($request->all());

    // Return a JSON response indicating success
    return response()->json(['success' => true, 'warehouse' => $warehouse]);
}

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return response()->json(['success' => true]);
    }

}
