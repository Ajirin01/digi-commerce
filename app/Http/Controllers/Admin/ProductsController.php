<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Shop;

use Validator;
use Session;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();

        // return response()->json(Auth::user()->role == 'seller');

        if(Auth::user()->role == 'seller'){
            $products = Product::where('shop_id', Auth::user()->seller->shop->id)->get();
        }
        return view('Admin.Products.product_list',['products' => $products]);
    }

    public function createOption(){
        $shops = Shop::all();

        // return response()->json(Auth::user()->seller->shop->id);

        if(Auth::user()->role == 'seller'){
            $shops = Shop::where('id', Auth::user()->seller->shop->id)->get();
        }

        return view('Admin.Products.create_option', ['shops'=> $shops]);
    }

    public function bulkUpdateOption(){
        $shops = Shop::all();

        // return response()->json(Auth::user()->seller->shop->id);

        if(Auth::user()->role == 'seller'){
            $shops = Shop::where('id', Auth::user()->seller->shop->id)->get();
        }

        return view('Admin.Products.bulk_update_option', ['shops'=> $shops]);
    }
    
    public function create(Request $request)
    {
        $brands = Brand::all();
        $categories = Category::all();
        $shop = Shop::find($request->shop_id);

        if(Auth::user()->role == 'seller'){
            $shop = Shop::find(Auth::user()->seller->shop->id);
        }

        // return response()->json($shop);

        return view('Admin.Products.product_creation_form', ['brands'=> $brands, 'categories'=> $categories, 'shop'=> $shop]);
    }
    
    public function store(Request $request)
    {
        // return response()->json($request->all());
        $rule = [
            'name' => 'required|min:3|max:191',
            'description' => 'required|min:5|max:1000',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'status' => 'nullable',
            'sale_type' => 'required|in:featured,hot_sale,new_arrival,normal',
            'variations' => 'json|nullable',
            'photos' => 'array|nullable',
            'percent_off' => 'nullable|numeric',
            'sale_start' => 'nullable|date',
            'sale_end' => 'nullable|date|after:sale_start',
            'shop_id' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $requestData = $request->all();

        // Handle status checkbox
        $requestData['status'] = $request->has('status') ? 'active' : 'inactive';

        // Handle variations
        $colors = $request->input('color', []);
        $sizes = $request->input('size', []);
        $prices = $request->input('color_price', []);

        // return response()->json([$colors, $prices]);

        $colorVariations = array_combine($colors, $prices);
        $sizeVariations = array_combine($sizes, $request->input('size_price', []));

        $variations = [
            'colors' => $colorVariations,
            'sizes' => $sizeVariations,
        ];

        $requestData['variations'] = json_encode($variations);

        if(Auth::user()->role == 'seller'){
            $requestData['status'] = 'pending';
        }else{
            $requestData['status'] = 'active';
        }

        // Handle photos
        if ($request->hasFile('photos')) {
            $photos = [];
            $uploadPath = public_path('uploads/');

            foreach ($request->file('photos') as $photo) {
                $photoName = rand(123456789, 999999999) . '.' . $photo->getClientOriginalExtension();
                $photo->move($uploadPath, $photoName);
                $photos[] = asset('uploads/' . $photoName);
            }

            $requestData['photos'] = json_encode($photos);
        }else{
            $requestData['photos'] = json_encode([asset('uploads/' . 'no_photo.jpeg'), asset('uploads/' . 'no_photo.jpeg')]);
        }

        // Create product
        Product::create($requestData);

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    
    public function show($id)
    {
        return response()->json("product details");
    }

    public function edit($id)
    {
        // return response()->json($request->all());
        $categories = Category::all();
        $product = Product::find($id);
        $brands = Brand::all();

        $brand = Brand::find($product->brand_id);
        $category = Category::find($product->category_id);

        // return response()->json($category);
        // echo json_encode($brand);
        // exit;

        // return response()->json(json_decode($product->variations)->colors);

        return view('Admin.Products.product_edit_form',['product'=> $product, 
        'categories'=> $categories, 'brands'=> $brands, 'category'=> $category, 'brand'=> $brand]);
    }

    public function update(Request $request, $id)
    {
        // return response()->json($request->all());
        // return response()->json($variations);

        $rule = [
            // 'category'=> 'required',
            // 'brand'=> 'required',
            'name'=> 'required| min:3| max: 191',
            'description'=> 'required| min: 5| max: 1000',
        ];
        
        $valid = Validator::make($request->all(),$rule);

        $brand = Brand::find($request->brand_id);
        $category = Category::find($request->category_id);

        // $data = $request->all();

        $requestData = $request->all();

        if($request->status == "on"){
            $requestData['status'] = "active";
        }else{
            $requestData['status'] = "inactive";
        }

        

        // Extract color, size, and price arrays
        $colors = isset($requestData['color']) ? $requestData['color'] : [];
        $sizes = optional($requestData)['size'] ?? [];
        $prices = $requestData['color_price'] ?? [];

        // Create color array with associated prices
        $colorVariations = array_combine($colors, $prices);

        // Create size array with associated prices
        $sizeVariations = array_combine($sizes, $requestData['size_price'] ?? []);

        $variations = [
            'colors' => $colorVariations,
            'sizes' => $sizeVariations,
        ];

        $requestData['variations'] = json_encode($variations);

        // return response()->json($requestData['variations']);
        
        if($valid->fails()){
            // return response()->json($valid->errors());
            return redirect()->back()->with('errors',$valid->errors());
        }else{
            if ($request->hasFile('photos')) {
                $photos = [];
                $upload_path = public_path('uploads/');

                if(count($request->file('photos')) < 2){
                    return redirect()->back()->with('error','Please make sure you select two or more product photos');
                }
        
                foreach ($request->file('photos') as $photo) {
                    $photo_name = rand(123456789, 999999999) . '.' . $photo->getClientOriginalExtension();
                    $photo->move($upload_path, $photo_name);
                    $photos[] =  asset('uploads/' . $photo_name);
                }
        
                // Update the photos array in your request data
                $requestData['photos'] = json_encode($photos);

                $product_to_update = Product::find($id);

                $update_product = $product_to_update->update($requestData);
                // $product_to_update->image = $image_name;

                if($update_product){
                    // $image_file->move($upload_path, $image_name);
                    return redirect()->back()->with('success','Product updated!');
                }else{
                    return redirect()->back()->with('errors','Could not update product');
                }
            }else{
                $product_to_update = Product::find($id);

                // return response()->json($requestData);
                $update_product = $product_to_update->update($requestData);
                return redirect()->back()->with('success','Product updated!');
            }
        }
    }
    
    public function destroy($id)
    {
        // return response()->json("product delete handler");
        $product_to_delete = Product::find($id);

        $delete_product = $product_to_delete->delete();

        if($product_to_delete){
            return redirect()->back()->with('success', 'Product deleted!');
        }else{
            return redirect()->back()->with('errors', 'Product could not delete successfully!');
        }return redirect()->back()->with('success', 'Product deleted!');
    }


    public function productBulkEditCreate(Request $request){
        $products = Product::where('shop_id', $request->shop_id)->get();
        return view('Admin.Products.bulk_edit_form', ['products'=> $products]);
    }

    // public function productBulkEditStoreAsaba(Request $request){
    //     $loop_count = count($request->checked);

    //     for ($i=0; $i < $loop_count; $i++) { 
    //         if($request->checked[$i] === "on"){
    //             if($request->action === 'update'){
    //                 Product::where('id', $request->id[$i])->update(['price'=> $request->price[$i], 'stock'=> $request->stock[$i], 'status'=> $request->status[$i]]);
    //             }else{
    //                 Product::where('id', $request->id[$i])->delete();
    //             }
    //         }
    //     }
        
    //     return redirect()->back()->with('success', 'products successfully' . ($request->action === 'update' ? ' updated' : ' deleted'));
    // }

    public function productBulkEditStore(Request $request){
        // return response()->json($request->all());
        $loop_count = count($request->checked);

        for ($i=0; $i < $loop_count; $i++) { 
            if($request->checked[$i] === "on"){
                if($request->action === 'update'){
                    $stock = $request->quantity[$i];
                    if(Auth::user()->role == 'seller'){
                        Product::where('id', $request->id[$i])->update(['price'=> $request->price[$i], 'quantity'=> $stock]);
                    }else{
                        Product::where('id', $request->id[$i])->update(['price'=> $request->price[$i], 'quantity'=> $stock, 'status'=> $request->status[$i]]);
                    }
                }else{
                    Product::where('id', $request->id[$i])->delete();
                }
            }
        }

        return redirect()->back()->with('success', 'products successfully' . ($request->action === 'update' ? ' updated' : ' deleted'));
    }
}
