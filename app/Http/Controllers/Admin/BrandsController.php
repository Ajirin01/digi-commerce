<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand as Brand;
use Validator;
use Session;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('Admin.Brands.brand_list', ['brands'=> $brands]);
    }

    public function create()
    {
        return view('Admin.Brands.brand_creation_form');
    }

    public function store(Request $request)
    {
        $rule = [
            'name'=> 'required| min:3| max: 191'
        ];
        $data = array();
        $data['name'] = $request->name;

        if ($request->hasFile('photo')) {
            $upload_path = public_path('uploads/');
            // $photoPath = $request->file('photo')->store('category_photos', 'public');
            $photo = $request->file('photo');
            $photo_name = 'brand_'. rand(123456789, 999999999) . '.' . $photo->getClientOriginalExtension();
            $photo->move($upload_path, $photo_name);
            $photoPath =  asset('uploads/' . $photo_name);
            $data['photo'] = $photoPath;
        }
        
        $valid = Validator::make($request->all(),$rule);

        if($valid->fails()){
            // return response()->json($valid->errors());
            return redirect()->back()->with('errors',$valid->errors());
        }else{
            $create_brand = Brand::create($data);

            if($create_brand){
                return redirect()->back()->with('success','record created!');
            }else{
                return redirect()->back()->with('errors','could not create record');
            }
        }
        // return response()->json($request->all());
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $brand_to_edit = Brand::find($id);
        return view('Admin.Brands.brand_edit_form', ['brand_id'=>$id, 'brand'=>$brand_to_edit]);
    }

    public function update(Request $request, $id)
    {
        $brand_to_update = Brand::find($id);

        $data = [];

        $data['name'] = $request->name;

        if ($request->hasFile('photo')) {
            $upload_path = public_path('uploads/');
            // $photoPath = $request->file('photo')->store('category_photos', 'public');
            $photo = $request->file('photo');
            $photo_name = 'brand_'. rand(123456789, 999999999) . '.' . $photo->getClientOriginalExtension();
            $photo->move($upload_path, $photo_name);
            $photoPath =  asset('uploads/' . $photo_name);
            $data['photo'] = $photoPath;
        }

        $update_brand = $brand_to_update->update($data);

        if($update_brand){
            return redirect()->back()->with('success', 'Brand successfully updated!');
        }else {
            return redirect()->back()->with('errors', 'Brand could not successfully updated!');

        }
        // return response()->json($request->all());
    }

    public function destroy($id)
    {
        $brand_to_delete = Brand::find($id);

        $delete_brand = $brand_to_delete->delete();

        if($delete_brand){
            return redirect()->back()->with('success', 'Brand successfully deleted!');
        }else {
            return redirect()->back()->with('errors', 'Brand could not successfully deleted!');

        }
        // return response()->json($id);
    }
}
