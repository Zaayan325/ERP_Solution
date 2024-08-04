<?php

namespace App\Http\Controllers;

use App\Models\Uom;
use Illuminate\Http\Request;

class UomController extends Controller
{
    public function index()
    {
        $uoms = Uom::all();
        return view('admin.uoms.index', compact('uoms'));
    }

    public function create()
    {
        return view('admin.uoms.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:uoms,name']);
        $uom = Uom::create(['name' => $request->name]);
        return response()->json(['success' => true, 'uom' => $uom]);
    }

    public function edit(Uom $uom)
    {
        return view('admin.uoms.edit', compact('uom'));
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
