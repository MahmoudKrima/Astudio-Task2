<?php

namespace App\Http\Controllers\Api\Order;

use App\Models\Order;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Services\Api\Order\OrderService;
use App\Http\Resources\Api\Order\OrderResoruce;
use App\Http\Resources\Api\Order\OrderCollection;
use App\Http\Requests\Api\Order\StoreOrderRequest;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index()
    {
        $orders = $this->orderService->index();
        return ApiResponseTrait::apiResponse(new OrderCollection($orders));
    }

    public function show(Order $order)
    {
        $order = $this->orderService->show($order);
        return ApiResponseTrait::apiResponse(['order' => new OrderResoruce($order)]);
    }

    public function store(StoreOrderRequest $request)
    {
        $project = $this->orderService->store($request);
        return ApiResponseTrait::apiResponse(['order' => new OrderResoruce($project)], "Order Created Successfully", status: 201);
    }
}
