<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of user's addresses.
     */
    public function index()
    {
        $addresses = Auth::user()->addresses;
        return response()->json($addresses);
    }

    /**
     * Store a newly created address.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'pincode' => 'required|string|max:10',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'alternative_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $address = Address::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'pincode' => $request->pincode,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'alternative_phone' => $request->alternative_phone,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully',
            'address' => $address
        ]);
    }

    /**
     * Display the specified address.
     */
    public function show($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($address);
    }

    /**
     * Update the specified address.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'pincode' => 'required|string|max:10',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'alternative_phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        
        $address->update([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'pincode' => $request->pincode,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'alternative_phone' => $request->alternative_phone,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully',
            'address' => $address
        ]);
    }

    /**
     * Remove the specified address.
     */
    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);

        if ($address->orders()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This address is linked to an existing order and cannot be deleted. You can still add a new address for future orders.'
            ], 422);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ]);
    }
}
