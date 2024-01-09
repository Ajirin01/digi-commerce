<?php

// CategoryController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|unique:categories',
            'description' => 'string',
        ]);

        // Create a new category
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Return the created category
        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'string|unique:categories,name,' . $category->id,
            'description' => 'string',
        ]);

        // Update category details
        $category->update($request->all());

        // Return the updated category
        return response()->json($category, 200);
    }

    public function delete($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Delete the category
        $category->delete();

        // Return success response
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    public function query(Request $request)
    {
        // Get all categories
        $categories = Category::where($request->all())->get();

        // Return the list of categories
        return response()->json($categories, 200);
    }
}
