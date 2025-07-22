<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\ItemCondition;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_detail_page_displays_all_information()
    {
        $user = User::factory()->create();
        $condition = ItemCondition::factory()->create(['name' => '新品']);
        $category1 = Category::factory()->create(['name' => '家電']);
        $category2 = Category::factory()->create(['name' => '生活']);

        $item = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '炊飯器',
            'brand' => 'Panasonic',
            'price' => 9800,
            'condition_id' => $condition->id,
            'description' => '高性能な炊飯器です。',
            'image_path' => 'suihanki.jpg',
        ]);

        $item->categories()->attach([$category1->id, $category2->id]);

        $commentUser = User::factory()->create(['username' => 'コメント太郎']);
        Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
            'comment' => '使いやすそうですね！'
        ]);

        $response = $this->get(route('items.show', $item->id));

        $response->assertStatus(200);
        $response->assertSee('炊飯器');
        $response->assertSee('Panasonic');
        $response->assertSee('9,800');
        $response->assertSee('新品');
        $response->assertSee('高性能な炊飯器です。');
        $response->assertSee('家電');
        $response->assertSee('生活');
        $response->assertSee('コメント太郎');
        $response->assertSee('使いやすそうですね！');
        $response->assertSee('<img', false); // 画像表示の確認
    }
}
