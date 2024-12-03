<?php
namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Get all orders
    public function index()
    {
        $orders = Order::with('orderDetails.article')->get(); // Eager load the order details and articles
        return response()->json($orders);
    }

    // Get a specific order
    public function show($id)
    {
        $order = Order::with('orderDetails.article')->find($id);
        
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

   // Store a new order with details
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id' => 'required|exists:users,id',
        'total_amount' => 'required|numeric',
        'order_details' => 'required|array',
        'order_details.*.article_id' => 'required|exists:articles,id', // Ensure article_id exists in articles table
        'order_details.*.quantity' => 'required|integer|min:1',
        'order_details.*.price' => 'required|numeric',
    ]);


    // Create the order
    $order = Order::create([
        'user_id' => $request->user_id,
        'total_amount' => $request->total_amount,
    ]);

    // Create order details
    foreach ($request->order_details as $detail) {
        $article=Article::findOrFail($detail['article_id']);

        OrderDetails::create([
            'order_id' => $order->id,
            'article_id' =>$article->id , // Ensure this is the correct article_id
            'quantity' => $detail['quantity'],
            'price' => $detail['price'],
        ]);
    }

    return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
}


    // Update an existing order
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'total_amount' => 'required|numeric',
            'order_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->update($request->only(['total_amount', 'order_date']));

        return response()->json(['message' => 'Order updated successfully', 'order' => $order]);
    }

    // Delete an order
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }

    public function getUserOrders($id)
    {
        $orders = Order::with('orderDetails.article')->where('user_id', $id)->get();
    
        if ($orders->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No orders found for this user.',
                'orders' => [], // Return an empty array for orders
            ]);
        }
        
    
        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }
    
}
