@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Order Details</h2>

    <!-- Back Button -->
    <a href="{{ route('order.index') }}" class="btn btn-secondary mb-3">← Back to Orders</a>

    <!-- Order Information -->
    <div class="card mb-4">
        <div class="card-header">
            <strong>Order #{{ $order->order_number }}</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                    <p><strong>User ID:</strong> {{ $order->user_id }}</p>
                    <p><strong>Shop ID:</strong> {{ $order->shop_id }}</p>
                    <p><strong>Status:</strong>
                        @if($order->status === 'completed')
                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                        @elseif($order->status === 'rejected')
                            <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                        @elseif($order->status === 'cancelled')
                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                        @else
                            <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                        @endif
                    </p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</p>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <p><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($order->updated_at)->format('d M Y, H:i') }}</p>
                    <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Billing Address:</strong> {{ $order->billing_address }}</p>
                    <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                    <p><strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }}</p>
                </div>
            </div>
        </div>


    <!-- Order Items -->
    <div class="card">
        <div class="card-header"><strong>Order Items</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price (each)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($order->items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No items found for this order.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
