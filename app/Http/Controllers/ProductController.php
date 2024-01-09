<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Shop;

class ProductController extends Controller
{
    public function getHomePageProducts()
    {
        $featured = Product::where("sale_type", "featured")->inRandomOrder()->limit(20)->get();
        $hot_sale = Product::where("sale_type", "hot_sale")->inRandomOrder()->limit(20)->get();
        $new_arrival = Product::where("sale_type", "new_arrival")->limit(20)->orderBy('id', 'desc')->get();
        $others = Product::where("sale_type", "normal")->inRandomOrder()->limit(20)->get();
        // featured','hot_sale','new_arrival','normal'

        // Fetch other required categories, brands, sellers, etc.

        // return response()->json([$featured, $hot_sale, $new_arrival, $others]);

        return view('shop.home', ['featuredProducts'=> $featured, 'hot_sale'=> $hot_sale, 'new_arrival'=> $new_arrival, 'other_products'=> $others]);
    }

    public function getCatalogProducts()
    {
        $catalogProducts = Product::paginate(30); // Adjust the pagination as needed

        // return response()->json($catalogProducts);

        return view('shop.all_products', ['products'=>  $catalogProducts]);
    }

    public function getProductsByBrand($brandId)
    {
        $brandProducts = Product::where('brand_id', $brandId)->paginate(20);
        $brand = Brand::find($brandId)->name;
        // return response()->json($brandProducts);

        return view('shop.products_by_brand', ['brand'=> $brand, 'products'=> $brandProducts]);
    }

    public function getProductsByCategory($categoryId)
    {
        $categoryProducts = Product::where('category_id', $categoryId)->paginate(20);

        // return response()->json($categoryProducts);

        $category = Category::find($categoryId)->name;
        // return response()->json($brandProducts);

        return view('shop.products_by_category', ['category'=> $category, 'products'=> $categoryProducts]);
    }

    public function getProductsByShop($shopId)
    {
        $shopProducts = Product::where('shop_id', $shopId)->paginate(20);

        // return response()->json($categoryProducts);

        $shop = Shop::find($shopId)->name;
        // return response()->json($brandProducts);

        return view('shop.products_by_shop', ['shop'=> $shop, 'products'=> $shopProducts]);
    }

    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        $category_id = $request->category_id;

        if(isset($_GET['s']) && $category_id != null){
            $searchResults = Product::where('shop.name', $_GET['s'])->where('category_id', $request->category_id)->where('name', 'like', "%$query%")->paginate(20);
        }
        
        if($category_id == null && !isset($_GET['s'])){
            $searchResults = Product::where('name', 'like', "%$query%")->paginate(20);
        }

        if($category_id != null){
            $searchResults = Product::where('category_id', $request->category_id)->where('name', 'like', "%$query%")->paginate(20);
        }
        

        // return response()->json($searchResults);

        return view('shop.search_result', ['products'=> $searchResults, 'query'=> $query]);
    }

    public function productDetails($id)
    {
        $product = Product::findorFail($id);
        $productName = $product->name;
        $relatedProducts = Product::where('name', 'like', "%$productName%")->limit(10)->get();

        // return response()->json($product);
        return view('shop.product_detail', ['product'=> $product, 'relatedProducts'=> $relatedProducts]);
    }
}

