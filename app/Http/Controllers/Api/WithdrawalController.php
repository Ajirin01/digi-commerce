<?php

// WithdrawalController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
    public function query(Request $request)
    {
        $withdrawals = Withdrawal::where($request->all())->get();
        return response()->json($withdrawals, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:sellers,id',
            'amount' => 'required|numeric',
            'status' => 'required|in:pending,processed,failed',
            'earnings_to_transfer' => 'required|json',
            // Add other necessary validations
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $withdrawal = Withdrawal::create($request->all());

        return response()->json($withdrawal, 201);
    }

    public function update(Request $request, $id)
    {
        $withdrawal = Withdrawal::find($id);

        if (!$withdrawal) {
            return response()->json(['error' => 'Withdrawal not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'amount' => 'numeric',
            'status' => 'in:pending,processed,failed',
            'earnings_to_transfer' => 'json',
            // Add other necessary validations
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $withdrawal->update($request->all());

        return response()->json($withdrawal, 200);
    }

    public function delete($id)
    {
        $withdrawal = Withdrawal::find($id);

        if (!$withdrawal) {
            return response()->json(['error' => 'Withdrawal not found'], 404);
        }

        $withdrawal->delete();

        return response()->json(['message' => 'Withdrawal deleted successfully'], 200);
    }
}

