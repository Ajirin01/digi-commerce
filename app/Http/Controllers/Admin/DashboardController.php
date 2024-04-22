<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Cart;
use App\Models\Seller;
use App\Models\Earning;

use Carbon\Carbon;
use Session;

class DashboardController extends Controller
{
    public function dashboard(){
        // $products = Product::take(20)->get();
        $products = Product::all();

        if(Auth::user()->role == "seller"){
            $products = Product::where('shop_id', Auth::user()->seller->shop->id)->get();
        }

        $latest_orders = Order::orderBy('id', 'desc')->take(7)->get();
        $orders = Order::all();
        // $products = Product::all();
        // $jan_sale = Sale::where();

        $latest_products = Product::orderBy('id', 'desc')->take(10)->get();

        // $sales = Sale::all();
        $carts = Cart::all();
        $users = User::where('role', 'user')->get();
        $sellers = Seller::all();

        if (Auth::check() && Auth::user()->seller) {
            $pending_earnings = Earning::where('seller_id', Auth::user()->seller->id)->where('paid', false)->sum('amount');
            $paid_earnings = Earning::where('seller_id', Auth::user()->seller->id)->where('paid', true)->sum('amount');
            $sales_seller = Product::where('shop_id', Auth::user()->seller->shop->id)->sum('sold');

        }else{
            $pending_earnings = 0;
            $paid_earnings = 0;
            $sales_seller = 0;
        }

        
        // sales by role
        $sales = Order::where('status', 'completed')->get();
        // $sales_seller = Product::where('shop_id', Auth::user()->seller->shop->id)->orderBy('id', 'desc')->get();
        // $sales_seller = Product::where('shop_id', Auth::user()->seller->shop->id)->sum('sold');

        // $sales = Sale::where('sale_type', 'wholesale')->where('status', 'confirmed')->get();
        // return response()->json($sales_seller);

        $month_sale = [];
        $months = [];
        $month_sale[0] = [];
        $month_sale[1] = [];
        $month_sale[2] = [];
        $month_sale[3] = [];
        $month_sale[4] = [];
        $month_sale[5] = [];
        $month_sale[6] = [];
        $month_sale[7] = [];
        $month_sale[8] = [];
        $month_sale[9] = [];
        $month_sale[10] = [];
        $month_sale[11] = [];
        $month_sale[12] = [];

        // return response()->json($month_sale);
        for ($i=0; $i < count($sales); $i++) { 
            for ($j=0; $j < 12; $j++) { 
                if (Carbon::parse($sales[$i]->created_at)->month == $j+1) {
                    $total = $sales[$i]->total_with_shipping;
                    array_push($month_sale[$j], $total);
                    array_push($months, Carbon::parse($sales[$i]->created_at)->format('M'));
                }
            }
        }

        $months_array = array_values(array_unique($months));

        // return response()->json(array_values(array_unique($month_sale[0])));

        $sale_recap = [];

        for ($i=0; $i < 12; $i++) { 
            if (count($month_sale[$i]) == 0) {
                ;
            }else{
                array_push($sale_recap, ['name' => '', 'data'=> $month_sale[$i]]);
            }
            
        }

        $dis = DashboardController::getSaleTotal($sales);
        // return response()->json($dis);
        // $dis_retail = DashboardController::getSaleTotal($sales_retail);
        // $dis_wholesale = DashboardController::getSaleTotal($sales_wholesale);
        
        
        // return response()->json(Carbon::parse($sales[0]->created_at)->month);
        return view('Admin.dashboard',['latest_orders'=> $latest_orders,
                    'latest_products'=> $latest_products, 'products'=> $products,
                    'sales'=> $sales, 
                    // 'total_orders'=> $orders,
                    'users'=> $users, 
                    'sellers'=> $sellers,
                    'months'=> $months_array,
                    'sales_total'=> $dis,
                    'sale_recap'=> $sale_recap,
                    'sales_seller'=> $sales_seller,
                    'pending_earnings'=> $pending_earnings,
                    'paid_earnings'=> $paid_earnings,
                    // 'sales_wholesale'=> $sales_wholesale,
                    // 'sales_total_retail'=> $dis_retail,
                    // 'sales_total_wholesale'=> $dis_wholesale
                ]);
    }

    private function getSaleTotal($sales){
        $dis = 0;
        for ($i=0; $i < count($sales); $i++) { 
            $total = $sales[$i]->total_with_shipping;
            $discount = 0;
            $dis = $dis + ($total - $discount);
        }

        return $dis;
    }
}
