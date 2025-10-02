@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Orders</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="bg-light">
                <tr>
                    <th>No</th>
                    <th>Delivery Date</th>
                    <th>User Code</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                        <td>{{ $order->order_number ?? '-' }}</td>
                        <td>
                            @if(in_array($order->status, ['accepted', 'completed']))
                                <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                            @elseif($order->status === 'cancelled')
                                <span class="badge bg-danger">{{ ucfirst($order->status) }}</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-info btn-sm">Detail</a>

                            @if($order->status === 'pending')
                                <form action="{{ route('order.accept', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                </form>

                                <form action="{{ route('order.reject', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this order?')">Reject</button>
                                </form>
                            @elseif($order->status === 'processing')
                                <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm"
                                        onclick="return confirm('Are you sure you want to cancel this order?');">
                                        Cancel
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">No actions available</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
