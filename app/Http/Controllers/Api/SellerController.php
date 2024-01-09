<?php

// app/Http/Controllers/SellerController.php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seller;

class SellerController extends Controller
{
    // public function index()
    // {
    //     $sellers = Seller::all();
    //     return response()->json(['sellers' => $sellers], 200);
    // }

    public function query(Request $request)
    {
        $sellers = Seller::where($request->all())->get();
        return response()->json(['sellers' => $sellers], 200);
    }

    // public function show($id)
    // {
    //     $seller = Seller::find($id);

    //     if (!$seller) {
    //         return response()->json(['message' => 'Seller not found'], 404);
    //     }

    //     return response()->json(['seller' => $seller], 200);
    // }

    public function create(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'account_number' => 'required|string',
            'bank_name' => 'required|string',
            // Add any other fields you need
        ]);

        // Create a new seller
        $seller = Seller::create($request->all());

        return response()->json(['seller' => $seller], 201);
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::find($id);

        if (!$seller) {
            return response()->json(['message' => 'Seller not found'], 404);
        }

        // Validate the request data
        $this->validate($request, [
            'account_number' => 'required|string',
            'bank_name' => 'required|string',
            // Add any other fields you need
        ]);

        // Update seller
        $seller->update($request->all());

        return response()->json(['seller' => $seller], 200);
    }

    public function destroy($id)
    {
        $seller = Seller::find($id);

        if (!$seller) {
            return response()->json(['message' => 'Seller not found'], 404);
        }

        // Delete seller
        $seller->delete();

        return response()->json(['message' => 'Seller deleted successfully'], 200);
    }
}
