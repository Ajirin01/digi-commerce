<?php

// OrdersController.php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function query(Request $request)
    {
        $orders = Order::where($request->all())->get();
        return response()->json($orders, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'shop_id' => 'required|exists:shops,id',
            'total_with_shipping' => 'required|numeric',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'shipping_address' => 'required|json',
            'order_details' => 'required|json',
            // Add other necessary validations
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $order = Order::create($request->all());

        return response()->json($order, 201);
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'total_with_shipping' => 'numeric',
            'status' => 'in:pending,processing,shipped,delivered,cancelled',
            'shipping_address' => 'json',
            'order_details' => 'json',
            // Add other necessary validations
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $order->update($request->all());

        return response()->json($order, 200);
    }

    public function delete($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}

