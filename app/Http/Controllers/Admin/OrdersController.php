<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Earning;
use Session;

class OrdersController extends Controller
{
    public function getOrdersByType($type){
        if($type == 'all'){
            $orders = Order::all();
        }else if($type == 'pending'){
            $orders = Order::where('status', 'pending')->get();
        }
        else if($type == 'shipped'){
            $orders = Order::where('status', 'shipped')->get();
        }else if($type == 'cancelled'){
            $orders = Order::where('status', 'canceled')->get();
        }else if($type == 'completed'){
            $orders = Order::where('status', 'completed')->get();
        }else{
            $orders = Order::all();
        }
        // return response()->json($orders);
        return view('Admin.Orders.orders_list',['orders'=> $orders, 'type'=> $type]);
    }

    public function orderDetails($id){
        $order = Order::find($id);

        $order_cart = json_decode($order->order_details);
        $order_shipping_address = $order->shipping_address;
        // return response()->json(json_decode($order));
        
        return view('Admin.Orders.order_details',['order' => $order, 'order_cart'=> $order_cart, 'address'=> $order_shipping_address]);
    }

    public function updateOrderStatus($id, Request $request){
        // return response()->json([$id, $request->all()]);

        if($request->status === "completed"){
            $order = Order::find($id);

            $order_details = json_decode($order->order_details);

            $data = [];
            
            foreach ($order_details as $order_detail) {
                $shop = Shop::find($order_detail->product->shop_id);
                $product = $order_detail->product;
                $price = $order_detail->price;

                // $data['shop'] = $shop;
                // $data['product'] = $product;
                // $data['price'] = $price;

                Earning::create(['seller_id'=> $shop->seller_id, 'amount'=> $price, 'paid'=> false]);
            }
            // return response()->json($data);
        }
        // Order::find($id)->update($request->all());
        return redirect()->back();
    }
}
