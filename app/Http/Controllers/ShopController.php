<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    /**
     * Get shop by ID
     */
    public function getShop($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        return response()->json($shop);
    }

    /**
     * Get shop's products
     */
    public function getShopProducts($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        $products = $shop->products;

        return response()->json($products);
    }

    /**
     * Search shop's products
     */
    public function searchShopProducts(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'query' => 'required|string',
        ]);

        $shop = Shop::find($request->input('shop_id'));

        if (!$shop) {
            return response()->json(['error' => 'Shop not found'], 404);
        }

        $query = $request->input('query');
        $products = $shop->products()->where('name', 'like', "%$query%")->get();

        return response()->json($products);
    }
}
