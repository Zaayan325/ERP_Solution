<?php

namespace App\Http\Controllers;

use App\Models\UOM;
use Illuminate\Http\Request;

class UomController extends Controller
{
    public function index()
    {
        $uoms = Uom::all();
        return view('uoms.index', compact('uoms'));
    }

    public function create()
    {
        return view('uoms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:uoms',
        ]);

        Uom::create($request->all());

        return redirect()->route('uoms.index')->with('success', 'Unit of Measurement created successfully.');
    }

    public function edit(Uom $uom)
    {
        return view('uoms.edit', compact('uom'));
    }

    public function update(Request $request, Uom $uom)
    {
        $request->validate([
            'name' => 'required|unique:uoms,name,' . $uom->id,
        ]);

        $uom->update($request->all());

        return redirect()->route('uoms.index')->with('success', 'Unit of Measurement updated successfully.');
    }

    public function destroy(Uom $uom)
    {
        $uom->delete();

        return redirect()->route('uoms.index')->with('success', 'Unit of Measurement deleted successfully.');
    }
}
