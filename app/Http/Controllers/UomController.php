<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Illuminate\Http\Request;

class UomController extends Controller
{
    public function index()
    {
        $uoms = Uom::paginate(10); // 10 items per page
        return response()->json([
            'uoms' => $uoms->items(),
            'pagination' => [
                'total' => $uoms->total(),
                'per_page' => $uoms->perPage(),
                'current_page' => $uoms->currentPage(),
                'last_page' => $uoms->lastPage(),
                'from' => $uoms->firstItem(),
                'to' => $uoms->lastItem()
            ]
        ]);
    }


    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:uoms,name']);
        $uom = Uom::create(['name' => $request->name]);
        return response()->json(['success' => true, 'uom' => $uom]);
    }

    

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|unique:uoms,name,' . $id]);
        $uom = Uom::findOrFail($id);
        $uom->update(['name' => $request->name]);
        return response()->json(['success' => true, 'uom' => $uom]);
    }

    public function destroy($id)
    {
        $uom = Uom::findOrFail($id);
        $uom->delete();
        return response()->json(['success' => true]);
    }
}
