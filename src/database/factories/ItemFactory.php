<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use App\Models\ItemCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->words(2, true),
            'brand' => $this->faker->company,
            'price' => $this->faker->numberBetween(1000, 10000),
            'condition_id' => ItemCondition::factory(),
            'description' => $this->faker->paragraph,
            'image_path' => null, // 画像アップロードなしでテストするなら null でOK
            'is_sold' => false,
        ];
    }
}
