<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_and_icon_and_count_change()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->get(route('items.show', $item->id))
            ->assertSee('0')          // 初期いいね数が0
            ->assertDontSee('liked'); // アイコン状態も未いいね

        // いいね押下（通常は AJAX or POST route）
        $response = $this->actingAs($user)
            ->post(route('items.like', $item->id));

        $response->assertStatus(302);

        // DBに記録されているか
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 数字とアイコンに変化があるか
        $this->get(route('items.show', $item->id))
            ->assertSee('1')       // いいねが1に
            ->assertSee('liked');  // クラスや altテキストで判定
    }

    public function test_user_can_unlike_and_count_and_icon_reset()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // まずいいね付与
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)
            ->get(route('items.show', $item->id))
            ->assertSee('1')
            ->assertSee('liked');

        // 再び押して解除
        $response = $this->actingAs($user)
            ->post(route('items.like', $item->id));

        $response->assertStatus(302);
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->get(route('items.show', $item->id))
            ->assertSee('0')
            ->assertDontSee('liked');
    }
}
