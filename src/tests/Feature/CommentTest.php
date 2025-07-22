<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{

    public function test_authenticated_user_can_post_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comments.store'), [
                'item_id' => $item->id,
                'comment' => '良い商品ですね！',
            ]);

        // 保存されているか
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => '良い商品ですね！',
        ]);

        // リダイレクト先 or ステータス
        $response->assertStatus(302);
    }

    public function test_guest_cannot_post_comment()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('comments.store'), [
            'item_id' => $item->id,
            'comment' => 'テスト',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('comments', [ // ← この形で特定のレコードの有無を確認
            'item_id' => $item->id,
            'comment' => 'テスト',
        ]);
    }

    public function test_validation_error_when_comment_empty()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comments.store'), [
                'item_id' => $item->id,
                'comment' => '',
            ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
        ]);
    }

    public function test_validation_error_when_comment_too_long()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $long = str_repeat('あ', 256);
        $response = $this->actingAs($user)
            ->post(route('comments.store'), [
                'item_id' => $item->id,
                'comment' => $long,
            ]);

        $response->assertSessionHasErrors([
            'comment' => 'コメントは255文字以内で入力してください',
        ]);
    }
}
