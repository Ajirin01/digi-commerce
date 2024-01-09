<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WishList;

class WishListController extends Controller
{
    public function index(){
        if(Auth::check()){
            $wishList = WishList::with('product')->where('user_id', Auth::user()->id)->get();
        }else{
            $wishList = [];
        }
        return view('shop.wishlist', ['wishList'=> $wishList]);
    }
}
