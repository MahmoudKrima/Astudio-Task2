<?php

namespace Database\Factories;

use App\Models\Order;
use App\Enum\OrderTrackingEnum;
use App\Models\OrderTracking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderTracking>
 */
class OrderTrackingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = OrderTracking::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'status' => $this->faker->randomElement(OrderTrackingEnum::vals()),
            'notes' => $this->faker->sentence,
            'changed_at' => now(),
        ];
    }
}
