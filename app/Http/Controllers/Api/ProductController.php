<?php

// ProductController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'description' => 'string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'shop_id' => 'required|exists:shops,id',
            'sold' => 'required|boolean',
            'status' => 'required|string',
            'sale_type' => 'string',
        ]);

        // Create a new product
        $product = Product::create($request->all());

        // Return the created product
        return response()->json($product, 201);
    }

    public function update($id, Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric',
            'quantity' => 'integer',
            'shop_id' => 'exists:shops,id',
            'sold' => 'boolean',
            'status' => 'string',
            'sale_type' => 'string',
        ]);

        // Find the product by ID
        $product = Product::findOrFail($id);

        // Update the product
        $product->update($request->all());

        // Return the updated product
        return response()->json($product, 200);
    }

    public function delete($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        // Return success response
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    public function show($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Return the product
        return response()->json($product, 200);
    }

    public function query(Request $request)
    {
        $products = Product::where($request->all())->get();

        // Return the products
        return response()->json($products, 200);
    }

    public function index()
    {
        // Get all products
        $products = Product::paginate(100);

        // Return the products
        return response()->json($products, 200);
    }
}

