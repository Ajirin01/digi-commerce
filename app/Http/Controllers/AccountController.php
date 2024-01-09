<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\Seller;
use App\Models\Shop;


class AccountController extends Controller
{
    public function dashboard(){
        return view('shop.myAccount.dashboard');
    }

    public function orders(){
        $orders = Order::where('user_id', Auth::user()->id)->get();

        return view('shop.myAccount.orders', ['orders'=> $orders]);
    }

    public function addresses(){
        $addresses = ShippingAddress::where('user_id', Auth::user()->id)->get();

        return view('shop.myAccount.addresses', ['addresses'=> $addresses]);
    }

    public function createAddress(){
        return view('shop.myAccount.add_address');
    }

    public function address($id){
        $address = ShippingAddress::find($id);

        return view('shop.myAccount.edit_address', ['address'=> $address]);
    }

    public function updateAddress(Request $request, $id){
        ShippingAddress::find($id)->update($request->all());
        return redirect()->route('shop.myAccount.addresses')->with('success', 'Address updated successfully');
    }

    public function profile(){
        return view('shop.myAccount.profile', ['user'=> Auth::user()]);
    }

    public function storeAddress(Request $request){
        ShippingAddress::create($request->all());
        return redirect()->route('shop.myAccount.addresses')->with('success', 'Address added successfully');
    }

    public function updateUserAccount(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'old_password' => 'sometimes|required_with:new_password',
            'new_password' => 'nullable|min:8',
        ]);

        $userData = $request->only(['first_name', 'last_name']);
        $userData['name'] = $request->first_name .' '. $request->last_name;

        $user = User::find(Auth::user()->id);

        // return response()->json($user);

        if ($request->filled('new_password')) {
            // return response()->json($this->updatePassword($user, $request->old_password, $request->new_password));
            if ($this->updatePassword($user, $request->old_password, $request->new_password)) {
                $request->user()->tokens()->delete();

                auth()->logout();

                return redirect()->route('login');
                return redirect()->route('shop.myAccount.profile')->with('success', 'Profile updated successfully');
            } else {
                return redirect()->route('shop.myAccount.profile')->with('error', 'Invalid old password or mismatched new passwords');
            }
        }

        $user->update($userData);

        return redirect()->route('shop.myAccount.profile')->with('success', 'Profile updated successfully');
    }

    public function becomeSeller()
    {
        $banks = file_get_contents(public_path('banks.json'));
        // return response()->json($banks);
        return view('shop.myAccount.become_seller', ['banks'=> json_decode($banks)]);
    }

    public function becomeSellerRequest(Request $request)
    {
        $sellerData = [];

        $sellerData['user_id'] = $request->user_id;
        $sellerData['account_number'] = $request->account_number;
        $sellerData['bank_name'] = $request->bank_name;

        $seller = Seller::create($sellerData);

        $shopData = [];

        $shopData['seller_id'] = $seller->id;
        $shopData['description'] = $request->description;
        $shopData['name'] = $request->name;
        $shopData['status'] = 'pending';

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $photoName = 'logo_'.rand(123456789, 999999999) . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads'), $photoName);
            $shopData['logo'] = asset('uploads/' . $photoName);
        }

        $create_shop = Shop::create($shopData);

        if ($create_shop) {
            return redirect(route('account.dashboard'))->with('success', 'Your shop request has been submitted!. We will review and get back to you');
        } else {
            return redirect()->back()->with('errors', 'Could not submit shop request');
        }

        // return response()->json($request->all());
    }

    function updatePassword(User $user, $oldPassword, $newPassword)
    {
        // return $oldPassword;
        if (Hash::check($oldPassword, $user->password)) {
            $user->update(['password' => Hash::make($newPassword)]);
            return true;
        }

        return false;
    }

}
