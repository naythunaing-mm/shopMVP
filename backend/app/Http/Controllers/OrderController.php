<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (! $user->shop) {
            abort(403, 'You do not have a shop.');
        }

        $orders = Order::where('shop_id', $user->shop->id)
            ->latest()
            ->get();
        return view('pages.shop_owner.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $user = auth()->user();

        if (! $user->shop || $order->shop_id !== $user->shop->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.shop_owner.order.show', compact('order'));
    }

    public function accept(Order $order)
    {
        $this->authorizeOrder($order);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be accepted.');
        }

        $order->status = 'completed';
        $order->save();

        return redirect()->route('order.index')->with('success', 'Order accepted.');
    }

    public function reject(Order $order)
    {
        $this->authorizeOrder($order);

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be rejected.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('order.index')->with('success', 'Order rejected.');
    }

    public function cancel(Order $order)
    {
        $this->authorizeOrder($order);

        if (! in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Only pending or processing orders can be cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('order.index')->with('success', 'Order cancelled.');
    }

    private function authorizeOrder(Order $order)
    {
        $user = auth()->user();

        if (! $user->shop || $order->shop_id !== $user->shop->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
