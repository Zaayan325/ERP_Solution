<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:owner|salesperson');
    }

    public function index()
    {
        $shops = Auth::user()->shops; // Fetch shops owned by the logged-in user
        return view('shops.index', compact('shops'));
    }

    public function create()
    {
        return view('shops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:shops,name',
            'address' => 'required|string',
        ]);

        Auth::user()->shops()->create([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect()->route('shops.index')->with('success', 'Shop added successfully!');
    }

    public function edit(Shop $shop)
    {
        // Ensure the user owns this shop
        $this->authorize('update', $shop);

        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        // Ensure the user owns this shop
        if ($this->authorize('update', $shop)) {
        $request->validate([
            'name' => 'required|string|unique:shops,name,' . $shop->id,
            'address' => 'required|string',
        ]);

        $shop->update($request->only('name', 'address'));

        return redirect()->route('shops.index')->with('success', 'Shop updated successfully!');
    }

        return abort(403, 'Unauthorized action.');
    }

    public function destroy(Shop $shop)
    {
        // Ensure the user owns this shop
        if ($this->authorize('delete', $shop)) {
        $shop->delete();

        return redirect()->route('shops.index')->with('success', 'Shop deleted successfully!');
    }

        return abort(403, 'Unauthorized action.');
    }

}

