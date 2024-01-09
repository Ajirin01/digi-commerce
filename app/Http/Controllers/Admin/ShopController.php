<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use App\Models\shop;
use Validator;
use Session;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::all();
        return view('Admin.Shops.shop_list', ['shops' => $shops]);
    }

    public function create()
    {
        $users = User::all();
        $sellers = Seller::all();
        return view('Admin.Shops.shop_creation_form', ['sellers' => $sellers, 'users' => $users]);
    }

    public function edit($id)
    {
        $shop_to_edit = Shop::find($id);
        $sellers = Seller::all();
        return view('Admin.Shops.shop_edit_form', ['sellers' => $sellers, 'shop' => $shop_to_edit]);
    }

    public function store(Request $request)
    {
        $rules = [
            'seller_id' => 'required',
            'name' => 'required',
            // 'description' => 'required',
            // 'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
            'seller_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        $data = $request->all();

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        } else {

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $photoName = 'logo_'.rand(123456789, 999999999) . '.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('uploads'), $photoName);
                $data['logo'] = asset('uploads/' . $photoName);
            }

            $create_shop = Shop::create($data);

            if ($create_shop) {
                return redirect()->back()->with('success', 'Shop record created!');
            } else {
                return redirect()->back()->with('errors', 'Could not create shop record');
            }
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            // 'us_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            // 'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
            'seller_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        $data = $request->all();

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        } else {
            $shop_to_update = Shop::find($id);

            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $photoName = 'logo_'.rand(123456789, 999999999) . '.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('uploads'), $photoName);
                $data['logo'] = asset('uploads/' . $photoName);
            }

            $update_shop = $shop_to_update->update($data);

            if ($update_shop) {
                if($request->status == 'active'){
                    $shop_to_update->seller->user->role = 'seller';
                    $shop_to_update->seller->user->save();
                 }
                return redirect()->back()->with('success', 'Shop successfully updated!');
            } else {
                return redirect()->back()->with('errors', 'Shop could not be successfully updated!');
            }
        }
    }

    public function destroy($id)
    {
        $shop_to_delete = Shop::find($id);

        $delete_shop = $shop_to_delete->delete();

        if ($delete_shop) {
            return redirect()->back()->with('success', 'Shop successfully deleted!');
        } else {
            return redirect()->back()->with('errors', 'Shop could not be successfully deleted!');
        }
    }

}
