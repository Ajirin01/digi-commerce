<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;

class ShippingAddressController extends Controller
{
    // Function to add new shipping address
    public function addShippingAddress(Request $request)
    {
        $addressData = $request->validate([
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        $addressData['user_id'] = $request->user()->id;

        $shippingAddress = ShippingAddress::create($addressData);

        return response()->json(['message' => 'Shipping address added successfully', 'address' => $shippingAddress]);
    }

    // Function to update shipping address
    public function updateShippingAddress(Request $request, $id)
    {
        $addressData = $request->validate([
            'address_line_1' => 'string',
            'address_line_2' => 'nullable|string',
            'city' => 'string',
            'state' => 'string',
            'postal_code' => 'string',
        ]);

        $shippingAddress = ShippingAddress::findOrFail($id);

        // Check if the user owns the shipping address
        if ($request->user()->id !== $shippingAddress->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $shippingAddress->update($addressData);

        return response()->json(['message' => 'Shipping address updated successfully', 'address' => $shippingAddress]);
    }

    // Function to delete shipping address
    public function deleteShippingAddress(Request $request, $id)
    {
        $shippingAddress = ShippingAddress::findOrFail($id);

        // Check if the user owns the shipping address
        if ($request->user()->id !== $shippingAddress->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $shippingAddress->delete();

        return response()->json(['message' => 'Shipping address deleted successfully']);
    }

    // Function to get all user's shipping addresses
    public function getAllUserShippingAddresses(Request $request)
    {
        $user = $request->user();
        $shippingAddresses = $user->shippingAddresses;

        return response()->json(['addresses' => $shippingAddresses]);
    }

    // Function to get single user's shipping detail
    public function getSingleUserShippingDetail(Request $request, $id)
    {
        $shippingAddress = ShippingAddress::findOrFail($id);

        // Check if the user owns the shipping address
        if ($request->user()->id !== $shippingAddress->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['address' => $shippingAddress]);
    }
}
