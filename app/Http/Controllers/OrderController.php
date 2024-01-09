<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class OrderController extends Controller
{
    // Function to create a new order
    public function createOrder(Request $request)
    {
        // Validate the request data (adjust as needed)
        $request->validate([
            'total_with_shipping' => 'required|numeric|min:0',
            'status' => 'required|string',
            'shipping_address' => 'required|string',
            'order_details' => 'required|array', // Assuming order_details is an array, adjust if needed
            'user_id' => 'required|exists:users,id',
            'shop_id' => 'required|exists:shops,id',
        ]);

        // Create a new order
        $order = new Order([
            'total_with_shipping' => $request->input('total_with_shipping'),
            'status' => $request->input('status'),
            'shipping_address' => $request->input('shipping_address'),
            'order_details' => $request->input('order_details'),
            'user_id' => $request->input('user_id'),
            'shop_id' => $request->input('shop_id'),
            // Add any other fields you need for the order
        ]);

        $order->save();

        return response()->json(['message' => 'Order created successfully', 'order' => $order]);
    }

    // Function to get a list of orders
    public function getOrders()
    {
        // Get all orders (adjust as needed)
        $orders = Order::with('user', 'shop')->get();

        return response()->json(['orders' => $orders]);
    }

    // Function to get details of a specific order
    public function getOrderDetails($orderId)
    {
        // Find the order by ID (adjust as needed)
        $order = Order::with('user', 'shop')->where('id', $orderId)->first();

        // if (!$order) {
        //     return response()->json(['message' => 'Order not found'], 404);
        // }

        $order_details = json_decode($order->order_details);
        $checkout_sub_total = 0;

        // return response()->json(['order_details' => json_decode($order->order_details)]);
        return view('shop.myAccount.order_details', ['order_details' => $order_details, 'checkout_sub_total'=> $checkout_sub_total]);

    }

    // Add any other functions as needed based on your requirements
}