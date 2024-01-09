<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Validator;
use Session;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::all();
        return view('Admin.Sellers.seller_list', ['sellers'=> $sellers]);
    }

    public function create()
    {
        $users = User::all();
        return view('Admin.Sellers.seller_creation_form', ['users'=> $users]);
    }

    public function store(Request $request)
    {
        $rule = [
            'user_id'=> 'required',
            'bank_name' => 'required',
            'account_number' => 'required'
        ];
        $data = array();
        $data['name'] = $request->name;
        
        $valid = Validator::make($request->all(),$rule);

        if($valid->fails()){
            // return response()->json($valid->errors());
            return redirect()->back()->with('errors',$valid->errors());
        }else{
            $create_seller = Seller::create($request->all());

            if($create_seller){
                return redirect()->back()->with('success','record created!');
            }else{
                return redirect()->back()->with('errors','could not create record');
            }
        }
        // return response()->json($request->all());
    }

    public function edit($id)
    {
        $seller_to_edit = Seller::find($id);
        return view('Admin.Sellers.seller_edit_form', ['seller_id'=>$id, 'seller'=>$seller_to_edit]);
    }

    public function update(Request $request, $id)
    {
        $seller_to_update = Seller::find($id);

        // return response()->json($seller_to_update);

        $update_seller = $seller_to_update->update($request->all());

        if($update_seller){
            return redirect()->back()->with('success', 'Seller successfully updated!');
        }else {
            return redirect()->back()->with('errors', 'Seller could not successfully updated!');

        }
        // return response()->json($request->all());
    }

    public function destroy($id)
    {
        $seller_to_delete = Seller::find($id);

        $delete_seller = $seller_to_delete->delete();

        if($delete_seller){
            return redirect()->back()->with('success', 'Seller successfully deleted!');
        }else {
            return redirect()->back()->with('errors', 'Seller could not successfully deleted!');

        }
        // return response()->json($id);
    }
}
