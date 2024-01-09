<?php

// BrandController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|unique:brands',
            'description' => 'string',
        ]);

        // Create a new brand
        $brand = Brand::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Return the created brand
        return response()->json($brand, 201);
    }

    public function update(Request $request, $id)
    {
    // Find the brand by ID
        $brand = Brand::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'string|unique:brands,name,' . $brand->id,
            'description' => 'string',
        ]);

        // Update brand details
        $brand->update($request->all());

        // Return the updated brand
        return response()->json($brand, 200);
    }

    public function delete($id)
    {
        // Find the brand by ID
        $brand = Brand::findOrFail($id);

        // Delete the brand
        $brand->delete();

        // Return success response
        return response()->json(['message' => 'Brand deleted successfully'], 200);
    }

    public function query(Request $request)
    {
        // Get all brands
        $brands = Brand::where($request->all())->get();

        // Return the list of brands
        return response()->json($brands, 200);
    }
}

