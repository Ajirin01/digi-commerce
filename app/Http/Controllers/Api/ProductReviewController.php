<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function query(Request $request)
    {
        $reviews = ProductReview::where($request->all())->get();

        return response()->json($reviews);
    }

    // public function index()
    // {
    //     $reviews = ProductReview::all();

    //     return response()->json($reviews);
    // }

    // public function show(ProductReview $review)
    // {
    //     return response()->json($review);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $review = ProductReview::create($request->all());

        return response()->json($review, 201);
    }

    public function update(Request $request, ProductReview $review)
    {
        $request->validate([
            'rating' => 'integer|between:1,5',
            'comment' => 'nullable|string',
        ]);

        $review->update($request->all());

        return response()->json($review);
    }

    public function destroy(ProductReview $review)
    {
        $review->delete();

        return response()->json(null, 204);
    }
}
