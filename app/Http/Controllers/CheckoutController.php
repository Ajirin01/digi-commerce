<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Unicodeveloper\Paystack\Facades\Paystack;
use Hash;

use App\Models\Product;
use App\Models\Cart;
use App\Models\ShippingAddress;
use App\Models\Order;
use App\Models\User;


class CheckoutController extends Controller
{
    public function checkout()
    {
        return view('shop.checkout');
    }

    public function placeOrder(Request $request)
    {
        // return response()->json($request->all());
  
        // return $request->all();
  
        if($request->shipping_create_account === "on"){
          $data=array();
          $data['name'] = $request->shipping_first_name. " ". $request->shipping_last_name;
          $data['email'] = $request->shipping_email;
          $data['password'] = Hash::make($request->shipping_create_account_password);
          $data['phone'] = $request->shipping_mobile_number;
        
          $result = User::where('email',$request->shipping_email)->get();
          // return response()->json(count($result)>0);
          // exit;
          if(count($result) > 0){
            return redirect()->back()->with('error','email already exists!');
          }else if(count($result) == 0){
            $customer_id= User::create($data);
          }
  
          if($request->shop_cart != null){
            foreach (json_decode($request->shop_cart) as $key => $cart) {
              $cart_id = $cart->id;
    
              $product_from_cart = Cart::find($cart_id);
    
              if($product_from_cart == null){
                $data = [
                  "product_id"=> $cart->product_id,
                  "product_name"=> $cart->product->name,
                  "product_price"=> $cart->price,
                  "product_description"=> $cart->product->description,
                  "product_image"=> $cart->product->image,
                  "product_quantity"=> $cart->quantity,
                  "customer_id"=> Auth::user()->id
                ];
                  
                order::create($data);
              }else{
                  $product_from_cart->product_quantity = $product_from_cart->product_quantity + $cart->product_quantity;
                  $product_from_cart->save();
              }
            }
          }
  
        }
  
        
        // return Cart::where('customer_id', Session::get('customer_id'))->get();
        
        if($request['selected_payment_method'] == "pay_on_delivery"){
          return $this->payOnDelivery($request);
        }else{
          return $this->payOnline($request);
        }
  
  
    }

    public function paymentCallback(Request $request){
        $paymentDetails = Paystack::getPaymentData();
        // dd($paymentDetails);
        // exit;

        if($paymentDetails['status']){
          $order_information = [
            'total_with_shipping'=> $paymentDetails['data']['metadata']['order_total'],
            'status'=> $paymentDetails['data']['metadata']['status'],
            'shipping_address'=> $paymentDetails['data']['metadata']['address'],
            'shipping_name'=> $paymentDetails['data']['metadata']['name'],
            'shipping_email'=> $paymentDetails['data']['metadata']['email'],
            'shipping_phone'=> $paymentDetails['data']['metadata']['phone'],
            'order_details'=> $paymentDetails['data']['metadata']['order_details'],
            'user_id'=> $paymentDetails['data']['metadata']['customer_id'],
            'payment_method'=> "prepaid"
          ];
        }else{
          $order_information = [];
        }

        $shopCart= $order_information['order_details'];

        foreach (json_decode($shopCart) as $cart) {
          $table_product = Product::find($cart->product_id);

          $initial_sold = $table_product->sold;
          $new_sold = $initial_sold + $cart->quantity;

          $table_product->update(['sold'=> $new_sold]);
          // DB::update('update  tbl_products set sold ='.$new_sold.' where product_id  = ?', [$product->product_id]);
          // exit;

          if(Auth::check()){
            $cart = Cart::find($cart->id);
            $cart->delete();
          }

        }

        Order::create($order_information);

        return redirect(route('order.confirm'));

        // return response()->json($order_information);
    }

    public function orderConfirm()
    {
      return view('shop.order_confirm');
    }

    public function payOnline($shipping_details)
    {
      // return response()->json($shipping_details);
        $customer_id = Auth::check() ? Auth::user()->id : null;

        $form_data = [
            'email' => $shipping_details['shipping_email'],
            'amount' => $shipping_details['order_total'] * 100, // Amount in kobo
            'metadata' => [
                'name' => $shipping_details['shipping_first_name'].' '.$shipping_details['shipping_last_name'],
                'address' => $shipping_details['shipping_address']. ' State: '. $shipping_details['shipping_state']. ' City: '. $shipping_details['shipping_city']. ' LGA: '. json_decode($shipping_details['shipping_lga'])[1],
                'phone' => $shipping_details['shipping_mobile_number'],
                'email' => $shipping_details['shipping_email'],
                'order_details' => $shipping_details['shop_cart'],
                'order_total' => $shipping_details['order_total'],
                'prescription' => $shipping_details['prescription'],
                'customer_id' => $customer_id,
                'status' => 'pending'
            ]
        ];

        try {
          // Initialize the payment transaction and redirect the user to Paystack
          // $payment = Paystack::getAuthorizationUrl($form_data)->redirectNow();
          // or
          return Paystack::getAuthorizationUrl($form_data)->redirectNow();
          // return redirect($payment);
          // return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            // Handle exception
            return $e->getMessage();
        }

        // return redirect()->away($payment->data->authorization_url);
    }

  
    public function payOnDelivery($shipping_details)
    {
        // return $shipping_details;
        // return $shipping_details['shipping_address']. ' State: '. $shipping_details['shipping_state']. ' City: '. $shipping_details['shipping_city']. ' LGA: '. json_decode($shipping_details['shipping_lga'])[1];
        $ship_data = array();
        $ship_data['user_name'] = $shipping_details['shipping_first_name'].' '.$shipping_details['shipping_last_name'];
        $ship_data['shipping_address'] = $shipping_details['shipping_address']. ' State: '. $shipping_details['shipping_state']. ' City: '. $shipping_details['shipping_city']. ' LGA: '. json_decode($shipping_details['shipping_lga'])[1];
        $ship_data['user_phone'] = $shipping_details['shipping_mobile_number'];
        $ship_data['user_email'] = $shipping_details['shipping_email'];
        //$ship_data['order_id'] = rand(1234,9999);
        $ship_data['order_details'] = $shipping_details['shop_cart'];
        $ship_data['total_with_shipping'] = $shipping_details['order_total'];
        $ship_data['status'] = 'pending';
        if(Auth::check()){
          $ship_data['user_id'] = Auth::user()->id;
        }else{
          $ship_data['user_id'] = 0;
        }
        $ship_data['payment_method'] = "Pay on delivery";

        // exit;

        // return Cart::where('customer_id', Session::get('customer_id'))->get();


        $shopCart= $shipping_details['shop_cart'];
        

        // return $products;

        foreach (json_decode($shopCart) as $cart) {
          $table_product = Product::find($cart->product_id);

          $initial_sold = $table_product->sold;
          $new_sold = $initial_sold + $cart->quantity;

          $table_product->update(['sold'=> $new_sold]);

          // DB::update('update  tbl_products set sold ='.$new_sold.' where product_id  = ?', [$product->product_id]);
          // exit;

          if(Auth::check()){
            $cart = Cart::find($cart->id);
            $cart->delete();
          }

        }

        Order::create($ship_data);
              
        // return response()->json("Order placed"); 
        // if(Auth::check()){
        //   $shopCart = json_encode([]);
        // }

        return redirect(route('order.confirm'))->with('orderItems', $shopCart);
        
        // return view('callback');
    }

    
}
