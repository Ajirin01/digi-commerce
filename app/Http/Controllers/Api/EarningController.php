<?php

// EarningController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Earning;

class EarningController extends Controller
{
    public function query(Request $request)
    {
        // Get all earnings for a specific seller
        $earnings = Earning::where($request->all())->get();

        // Return the earnings
        return response()->json($earnings, 200);
    }

    public function delete(Request $request, $id)
    {
        // Find the earning by ID
        $earning = Earning::findOrFail($id);

        // Delete the earning
        $earning->delete();

        // Return success response
        return response()->json(['message' => 'Earning deleted successfully'], 200);
    }

    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'amount' => 'required|numeric|min:0',
            // Add other necessary validations
        ]);

        // Create a new earning record
        $earning = Earning::create([
            'seller_id' => $request->seller_id,
            'amount' => $request->amount,
            // Add other necessary fields
        ]);

        // Return the created earning
        return response()->json($earning, 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        // $request->validate([
        //     'seller_id' => 'required|exists:sellers,id',
        //     'amount' => 'required|numeric|min:0',
        //     // Add other necessary validations
        // ]);

        // Find the earning record by ID
        $earning = Earning::findOrFail($id);

        // Update the earning record
        // $earning->update([
        //     'seller_id' => $request->seller_id,
        //     'amount' => $request->amount,
        //     // Add other necessary fields
        // ]);

        $earning->update($request->all());

        // Return the updated earning
        return response()->json($earning, 200);
    }

}

