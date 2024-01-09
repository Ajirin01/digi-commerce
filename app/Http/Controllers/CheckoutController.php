<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Cart;
use App\Models\ShippingAddress;
use App\Models\Order;

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
          $data['customer_name'] = $request->shipping_first_name. " ". $request->shipping_last_name;
          $data['customer_email'] = $request->shipping_email;
          $data['password'] = md5($request->shipping_create_account_password);
          $data['mobile_number'] = $request->shipping_mobile_number;
        
          $result=DB::table('tbl_customer')
                 ->where('customer_email',$request->shipping_email)
                 ->get();
          // return response()->json(count($result)>0);
          // exit;
          if(count($result)>0){
            return redirect()->back()->with('error','email already exists!');
          }else if(count($result) == 0){
            $customer_id= DB::table('tbl_customer')
                            ->insertGetId($data);
            // return Redirect::to('/checkout');
            Session::put('customer_id', $customer_id);
          }
  
          if($request->shop_cart != null){
            foreach (json_decode($request->shop_cart) as $key => $cart) {
              $product_id = $cart->product_id;
    
              $product_from_cart = Cart::where('product_id', $product_id)->where('customer_id', Session::get('customer_id'))->first();
    
              if($product_from_cart == null){
                $data = [
                  "product_id"=> $cart->product_id,
                  "product_name"=> $cart->product_name,
                  "product_price"=> $cart->product_price,
                  "product_description"=> $cart->product_description,
                  "product_image"=> $cart->product_image,
                  "product_quantity"=> $cart->product_quantity,
                  "prescription"=> $cart->prescription,
                  "customer_id"=> Session::get('customer_id')
                ];
                  
                Cart::create($data);
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

    public function payOnline($shipping_details)
    {
        if(env('APP_DEBUG')){
          $paystack = new Paystack(env("PAYSTACK_SECRET_KEY_TEST"));
        }else{
          $paystack = new Paystack(env("PAYSTACK_SECRET_KEY"));
        }
  
        // Set the payment form data, including metadata
  
        if(Session::get('customer_id') !== null){
          $customer_id = Session::get('customer_id');
        }else{
          $customer_id = null;
        }
  
        if($shipping_details->has('prescription')){
          $file_ext = $shipping_details['prescription']->getClientOriginalExtension();
          $file_name = "prescription". rand(10000,99999). ".". $file_ext;
  
          $shipping_details['prescription']->move("images", $file_name);
          // return $file_name;
  
          $ship_data['prescription'] = $file_name;
  
        }else{
          $ship_data['prescription'] = "";
  
        }
  
        $form_data = array(
            'email' => $shipping_details['shipping_email'],
            'amount' => $shipping_details['order_total'] * 100,
            'metadata' => array(
              'name' => $shipping_details['shipping_first_name'].' '.$shipping_details['shipping_last_name'],
              'address' => $shipping_details['shipping_address']. ' State: '. $shipping_details['shipping_state']. ' City: '. $shipping_details['shipping_city']. ' LGA: '. json_decode($shipping_details['shipping_lga'])[1],
              'phone' => $shipping_details['shipping_mobile_number'],
              'email' => $shipping_details['shipping_email'],
              'order_details' => $shipping_details['checkout_cart'],
              'order_total' => $shipping_details['order_total'],
              'prescription' => $shipping_details['prescription'],
              'customer_id' => $customer_id,
              'status' => 'pending'
            )
        );
  
        // Create a new payment using the form data
        $payment = $paystack->transaction->initialize($form_data);
  
        // Redirect the customer to the payment authorization page
        return redirect()->away($payment->data->authorization_url);
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
            $cart = Cart::where('id', $cart->id)->first();
            $cart->delete();
          }

        }

        Order::create($ship_data);
              
        // return response()->json("Order placed"); 
        if(Auth::check()){
          $shopCart = json_encode([]);
        }

        return redirect(route('order.confirm'))->with('orderItems', $shopCart);
        
        // return view('callback');
    }

    public function orderConfirm()
    {
      return view('shop.order_confirm');
    }
}
