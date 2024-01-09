<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WishList;

class WishListController extends Controller
{
    // Display a listing of the resource.
    public function query(Request $request)
    {
        $wishLists = WishList::where($request->all())->get();
        return response()->json($wishLists);
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
        ]);

        $wishList = WishList::create($request->all());

        return response()->json($wishList);
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $wishList = WishList::find($id);
        $wishList->delete();

        return response()->json(['message' => 'WishList deleted successfully']);
    }
}
