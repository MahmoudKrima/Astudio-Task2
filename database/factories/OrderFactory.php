<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enum\OrderStatusEnum;
use App\Enum\OrderApprovalStatusEnum;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'order_number' => 'ORD' . $this->faker->unique()->numberBetween(1000, 9999),
            'total' => $this->faker->randomFloat(2, 100, 5000),
            'status' => $this->faker->randomElement(OrderStatusEnum::vals()),
            'approved_by' => 1,
            'approval_status' => $this->faker->randomElement(OrderApprovalStatusEnum::vals()),
        ];
    }
}
