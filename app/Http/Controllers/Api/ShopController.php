<?php

// ShopController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'admin_id' => 'required|exists:users,id',
        ]);

        // Create a new shop
        $shop = Shop::create($request->all());

        // Return the created shop
        return response()->json($shop, 201);
    }

    public function update($id, Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'string',
            'description' => 'string',
            'admin_id' => 'exists:users,id',
        ]);

        // Find the shop by ID
        $shop = Shop::findOrFail($id);

        // Update the shop
        $shop->update($request->all());

        // Return the updated shop
        return response()->json($shop, 200);
    }

    public function delete($id)
    {
        // Find the shop by ID
        $shop = Shop::findOrFail($id);

        // Delete the shop
        $shop->delete();

        // Return success response
        return response()->json(['message' => 'Shop deleted successfully'], 200);
    }

    public function show($id)
    {
        // Find the shop by ID
        $shop = Shop::findOrFail($id);

        // Return the shop
        return response()->json($shop, 200);
    }

    public function index()
    {
        // Get all shops
        $shops = Shop::paginate(100);

        // Return the shops
        return response()->json($shops, 200);
    }

    public function query(Request $request)
    {
        // Get all shops
        $shops = Shop::where($request->all())->get();

        // Return the shops
        return response()->json($shops, 200);
    }
}
