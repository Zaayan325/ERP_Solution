<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::paginate(10); // Pagination with 10 items per page
        return response()->json([
            'customers' => $customers->items(),
            'pagination' => [
                'total' => $customers->total(),
                'per_page' => $customers->perPage(),
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
                'from' => $customers->firstItem(),
                'to' => $customers->lastItem(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email|unique:customers',
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $customer = Customer::create($request->all());

        return response()->json(['success' => true, 'customer' => $customer]);
    }

    public function update(Request $request, Customer $customer)
    {
        Log::info('Update Request:', $request->all());

        try {
            $request->validate([
                'name' => 'required|unique:customers,name,' . $customer->id,
                'email' => 'nullable|email|unique:customers,email,' . $customer->id,
                'phone' => 'nullable',
                'address' => 'nullable',
            ]);
    
            $customer->update($request->all());
    
            return response()->json(['success' => true, 'customer' => $customer]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(['success' => true]);
    }
}
