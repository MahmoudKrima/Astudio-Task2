<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Api\Order\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();
        User::factory(5)->create();
        $this->orderService = $this->app->make(OrderService::class);
    }

    /** @test */
    public function it_creates_users_from_factory()
    {
        $this->assertDatabaseCount('users', 5);
    }

    /** @test */
    public function it_creates_an_order_successfully()
    {

        $data = [
            'items' => [
                ['product_name' => 'Product A', 'quantity' => 2, 'price' => 100],
                ['product_name' => 'Product B', 'quantity' => 1, 'price' => 200]
            ]
        ];

        $order = $this->orderService->createOrder($data);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'total' => 400,
        ]);

        $this->assertCount(2, $order->items);
    }
}
