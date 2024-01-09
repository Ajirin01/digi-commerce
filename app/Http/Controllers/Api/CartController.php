<?php

// CartController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\Cart;
use App\Models\WishList;

class CartController extends Controller
{
    public function manageCart(Request $request)
    {
        // return response()->json($request->all());
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            // Add other necessary validations
        ]);

        // Check if the product is already in the cart
        $existingCartItem = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->where('variations', $request->variations)
            ->first();

        // return response()->json($existingCartItem);

        if ($existingCartItem) {
            // Update the quantity if the product is already in the cart
            $existingCartItem->update(['quantity' => $request->quantity]);

            $wishList = WishList::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

            if($wishList){
                $wishList->delete();
            }
        } else {
            // Add a new item to the cart if the product is not already in the cart
            Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'variations' => $request->variations,
                // Add other necessary fields
            ]);
        }

        // Return the updated cart
        $updatedCart = Cart::with('product')->where('user_id', $request->user_id)->get();

        return response()->json($updatedCart, 200);
    }

    public function addToCart(Request $request)
    {
        // return response()->json($request->all());
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            // Add other necessary validations
        ]);

        // Check if the product is already in the cart
        // Decode and encode to normalize the order
        $requestVariations = json_decode($request->variations, true);
        // sort to match database variations
        if($requestVariations != null){
            arsort($requestVariations);
        }
        
        $normalizedRequestVariations = json_encode($requestVariations);

        // return response()->json($normalizedRequestVariations);

        // Query with normalized variations
        $existingCartItem = Cart::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            // ->where('variations', $normalizedRequestVariations)
            ->first();


        // remove white space from the variations

        if ($existingCartItem && (preg_replace('/\s+/', '', $existingCartItem->variations) == $normalizedRequestVariations)) {
            $newQuanity = $existingCartItem->quantity + $request->quantity;
            // Update the quantity if the product is already in the cart
            $existingCartItem->update(['quantity' => $newQuanity]);

            $wishList = WishList::where('user_id', $request->user_id)
            ->where('product_id', $request->product_id)
            ->first();

            if($wishList){
                $wishList->delete();
            }
        } else {
            // Add a new item to the cart if the product is not already in the cart
            Cart::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'variations' => $request->variations,
                // Add other necessary fields
            ]);
        }

        // Return the updated cart
        $updatedCart = Cart::with('product')->where('user_id', $request->user_id)->get();

        return response()->json($updatedCart, 200);
    }

    public function updateCarts(Request $request)
    {
        $carts = $request->all();

        foreach ($carts as $cart) {
            $cart_to_update = Cart::find($cart['id']);
            $cart_to_update->update(['quantity'=> $cart['quantity']]);
        }

        return response()->json($request->all());
    }

    public function removeCartItem(Request $request, $id)
    {
        // Find the cart item by ID
        $cartItem = Cart::findOrFail($id);

        // Delete the cart item
        $cartItem->delete();

        // Return success response
        // return response()->json(Cart::with('product')->where('user_id', Auth::user()->id)->get(), 200);
        return response()->json(Cart::with('product')->where('user_id', $request->user_id)->get(), 200);
    }

    public function query(Request $request)
    {
        // Get the user's cart items
        $carts = Cart::with('product')->where($request->all())->get();

        // Return the user's cart
        return response()->json($carts, 200);
    }
}
