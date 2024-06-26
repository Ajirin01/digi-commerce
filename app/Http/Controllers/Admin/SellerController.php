<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
            'account_number' => 'required',
            'name' => 'required',
            'description' => 'required',
            'logo' => 'required|image' // Add validation for logo as an image
        ];

        $valid = Validator::make($request->all(), $rule);

        if($valid->fails()){
            return redirect()->back()->with('errors', $valid->errors());
        } else {
            // Start a transaction
            DB::beginTransaction();
            
            try {
                // Create the seller
                $create_seller = Seller::create($request->all());

                // Check if the seller was created successfully
                if($create_seller) {
                    // Save the shop logo
                    if($request->hasFile('logo')){
                        $logo = $request->file('logo');
                        $logoPath = $logo->store('logos', 'public'); // Save the logo in the 'public/logos' directory
                    }

                    // Create the shop
                    $shop = Shop::create([
                        'name' => $request->name,
                        'description' => $request->description,
                        'logo' => $logoPath,
                        'status' => 'active', // Or any default status you want to set
                        'seller_id' => $create_seller->id
                    ]);

                    // Commit the transaction
                    DB::commit();

                    return redirect()->back()->with('success', 'Seller and Shop created successfully!');
                } else {
                    // Rollback the transaction
                    DB::rollBack();

                    return redirect()->back()->with('errors', 'Could not create seller');
                }
            } catch (\Exception $e) {
                // Rollback the transaction in case of any error
                DB::rollBack();

                return redirect()->back()->with('errors', 'An error occurred: ' . $e->getMessage());
            }
        }
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
