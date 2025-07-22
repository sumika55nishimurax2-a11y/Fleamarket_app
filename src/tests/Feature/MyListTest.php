<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_see_no_items()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('<p class="no-data">', false);
    }

    /** @test */
    public function liked_items_are_shown()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee($item->name);        // マイリストに商品が見えるか
        $response->assertDontSee('SOLD');         // 売れてないなら SOLD 表示なし
    }

    /** @test */
    public function sold_liked_items_show_sold_label()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['is_sold' => true]);

        // ← 修正ポイント：Likeレコードを作成
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee('SOLD');
    }

    /** @test */
    public function users_dont_see_their_own_items_even_if_liked()
    {
        $user = User::factory()->create();

        // ユーザー自身が出品した商品
        $item = Item::factory()->create(['user_id' => $user->id]);

        // Likeを作成（←これでリレーション確立）
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        // 自分の商品は表示されないことを検証
        $response->assertDontSee($item->name);
    }
}
