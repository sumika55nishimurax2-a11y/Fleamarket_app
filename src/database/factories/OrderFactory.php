<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Item;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'buyer_id' => User::factory(),
            'item_id' => Item::factory(),
            'shipping_address' => $this->faker->address,
            'payment_method_id' => PaymentMethod::factory(),
        ];
    }
}
