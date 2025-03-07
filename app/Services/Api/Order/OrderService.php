<?php

namespace App\Services\Api\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderTracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderService
{

    public function index()
    {
        return Order::with('items', 'approver', 'tracking')
            ->paginate();
    }

    public function show($user)
    {
        return Order::with('items', 'approver', 'tracking')
            ->findOrFail($user->id);
    }

    public function store($request)
    {
        $data = $request->validated();

        if (empty($data['items']) || count($data['items']) === 0) {
            throw new \Exception('Order must have at least one item.');
        }

        $total = collect($data['items'])->sum(fn($item) => $item['quantity'] * $item['price']);

        if ($total >= 1000) {
            $data['approval_status'] = 'pending';
        } else {
            $data['approval_status'] = 'approved';
        }

        return DB::transaction(function () use ($data, $total) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'total' => $total,
                'status' => 'pending',
                'approved_by' => null,
                'approval_status' => $data['approval_status']
            ]);

            $orderItems = collect($data['items'])->map(fn($item) => [
                'order_id' => $order->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'created_at' => now(),
                'updated_at' => now()
            ])->toArray();

            OrderItem::insert($orderItems);
            return $order;
        });
    }


    public function createOrder(array $data): Order
    {
        if (empty($data['items']) || count($data['items']) === 0) {
            throw new \Exception('Order must have at least one item.');
        }

        $total = collect($data['items'])->sum(fn($item) => $item['quantity'] * $item['price']);

        if ($total >= 1000) {
            $data['approval_status'] = 'pending';
        } else {
            $data['approval_status'] = 'approved';
        }

        return DB::transaction(function () use ($data, $total) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'total' => $total,
                'status' => 'pending',
                'approved_by' => null,
                'approval_status' => $data['approval_status']
            ]);

            $orderItems = collect($data['items'])->map(fn($item) => [
                'order_id' => $order->id,
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'created_at' => now(),
                'updated_at' => now()
            ])->toArray();

            OrderItem::insert($orderItems);
            return $order;
        });
    }


    public function approveOrder(Order $order): Order
    {
        if ($order->approval_status === 'approved') {
            throw new \Exception('Order is already approved.');
        }

        if ($order->total > 1000) {
            $order->update([
                'approved_by' => Auth::id(),
                'approval_status' => 'approved',
                'status' => 'approved'
            ]);

            OrderTracking::create([
                'order_id' => $order->id,
                'status' => 'approved',
                'notes' => 'Order approved'
            ]);
        }

        return $order;
    }
}
