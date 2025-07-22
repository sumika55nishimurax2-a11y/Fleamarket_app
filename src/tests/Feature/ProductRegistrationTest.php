<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Category;
use App\Models\ItemCondition;
use App\Models\Item;

class ProductRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_product_with_valid_data()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = ItemCondition::factory()->create();

        $this->actingAs($user);

        $postData = [
            'name' => 'テスト商品',
            'brand' => 'ブランド名',
            'description' => 'これはテスト用の説明文です。',
            'price' => 5000,
            'condition' => $condition->id,
            'category' => [$category->id],
            'image' => UploadedFile::fake()->image('test.jpg'),
        ];

        $response = $this->post(route('item.store'), $postData);

        $item = Item::latest()->first();

        $response->assertRedirect(route('items.show', ['id' => $item->id]));

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => 'テスト商品',
            'description' => 'これはテスト用の説明文です。',
            'price' => 5000,
            'user_id' => $user->id,
            'condition_id' => $condition->id,
        ]);

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);
    }
}
