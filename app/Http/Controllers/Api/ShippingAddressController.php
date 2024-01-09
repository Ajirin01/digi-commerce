<?php

// ShippingAddressController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingAddress;

class ShippingAddressController extends Controller
{
    public function manageShippingAddress(Request $request)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'zip_code' => 'required|string',
            // Add other necessary validations
        ]);

        // Check if the user already has a shipping address
        $existingAddress = ShippingAddress::where('user_id', $request->user_id)->first();

        if ($existingAddress) {
            // Update existing shipping address
            $existingAddress->update($request->all());
            $shippingAddress = $existingAddress;
        } else {
            // Create a new shipping address
            $shippingAddress = ShippingAddress::create($request->all());
        }

        // Return the shipping address
        return response()->json($shippingAddress, 200);
    }

    public function deleteShippingAddress(Request $request, $addressId)
    {
        // Find the shipping address by ID
        $shippingAddress = ShippingAddress::findOrFail($addressId);

        // Delete the shipping address
        $shippingAddress->delete();

        // Return success response
        return response()->json(['message' => 'Shipping address deleted successfully'], 200);
    }

    public function query(Request $request){
        return response()->json(ShippingAddress::where($request->all())->get(), 200);
    }
}
