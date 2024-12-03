<?php
namespace App\Http\Controllers;

use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends Controller
{
    // Get all order details
    public function index()
    {
        $orderDetails = OrderDetails::with('order', 'article')->get(); // Eager load related order and article
        return response()->json($orderDetails);
    }

    // Get a specific order detail
    public function show($id)
    {
        $orderDetail = OrderDetails::with('order', 'article')->find($id);

        if (!$orderDetail) {
            return response()->json(['message' => 'Order detail not found'], 404);
        }

        return response()->json($orderDetail);
    }

    // Create a new order detail
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'article_id' => 'required|exists:articles,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $orderDetail = OrderDetails::create($request->only(['order_id', 'article_id', 'quantity', 'price']));

        return response()->json(['message' => 'Order detail created successfully', 'order_detail' => $orderDetail], 201);
    }

    // Update an existing order detail
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $orderDetail = OrderDetails::find($id);

        if (!$orderDetail) {
            return response()->json(['message' => 'Order detail not found'], 404);
        }

        $orderDetail->update($request->only(['quantity', 'price']));

        return response()->json(['message' => 'Order detail updated successfully', 'order_detail' => $orderDetail]);
    }

    // Delete an order detail
    public function destroy($id)
    {
        $orderDetail = OrderDetails::find($id);

        if (!$orderDetail) {
            return response()->json(['message' => 'Order detail not found'], 404);
        }

        $orderDetail->delete();

        return response()->json(['message' => 'Order detail deleted successfully']);
    }
}

