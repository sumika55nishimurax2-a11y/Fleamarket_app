<?php

namespace Database\Factories;

use App\Models\ItemCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemConditionFactory extends Factory
{
    protected $model = ItemCondition::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), // 条件の名前（例：新品、中古など）
        ];
    }
}
