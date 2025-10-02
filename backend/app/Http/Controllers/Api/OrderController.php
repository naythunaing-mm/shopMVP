<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->where('user_id', auth()->id())->get();
        return response()->json(['success' => true, 'data' => $orders], 200);
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json(['success' => true, 'data' => $order], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'order_details' => 'required|array|min:1',
            'order_details.*.product_id' => 'required|exists:products,id',
            'order_details.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            foreach ($request->order_details as $detail) {
                $product = Product::findOrFail($detail['product_id']);

                if ($product->stock < $detail['quantity']) {
                    throw new \Exception("Insufficient stock for product: {$product->name}");
                }

                $totalAmount += $product->price * $detail['quantity'];
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'shop_id' => $request->shop_id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address,
                'payment_method' => $request->payment_method,
                'shipping_method' => $request->shipping_method,
            ]);

            foreach ($request->order_details as $detail) {
                $product = Product::findOrFail($detail['product_id']);

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $detail['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $detail['quantity'],
                ]);
            }

            DB::commit();

            return response()->json(['success' => true, 'data' => $order->load('items')], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create order', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending orders can be updated'], 400);
        }

        $request->validate([
            'shipping_address' => 'sometimes|string',
            'billing_address' => 'sometimes|string',
            'payment_method' => 'sometimes|string',
            'shipping_method' => 'sometimes|string',
        ]);

        $order->update($request->only([
            'shipping_address',
            'billing_address',
            'payment_method',
            'shipping_method',
        ]));

        return response()->json(['success' => true, 'data' => $order->load('items')], 200);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending orders can be deleted'], 400);
        }

        $order->delete();

        return response()->json(['success' => true, 'message' => 'Order deleted successfully'], 200);
    }

    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        if (!in_array($order->status, ['pending', 'processing'])) {
            return response()->json(['success' => false, 'message' => 'Only pending/processing orders can be cancelled'], 400);
        }

        $order->status = 'cancelled';
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully',
            'data' => $order->only(['id', 'status', 'updated_at'])
        ], 200);
    }

    public function details($id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        return response()->json(['success' => true, 'data' => $order->items], 200);
    }
}
