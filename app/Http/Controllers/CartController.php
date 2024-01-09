<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        // return response()->json(Cart::where("user_id", Auth::user()->id)->get());
        // return response()->json(Cart::where("user_id", 95)->get());
        if(Auth::check()){
            $carts = Cart::where("user_id", Auth::user()->id)->get();
        }else{
            $carts = [];
        }
        return view('shop.cart', ['carts'=> $carts]);
    }
}
