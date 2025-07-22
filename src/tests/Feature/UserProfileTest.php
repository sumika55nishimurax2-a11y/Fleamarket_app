<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile_displays_user_data_and_items()
    {
        $user = User::factory()->create([
            'username' => 'テスト太郎',
            'avatar' => 'avatar.jpg',
        ]);

        // 出品した商品
        $sellingItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品',
        ]);

        // 購入した商品
        $purchasedItem = Item::factory()->create();
        Order::factory()->create([
            'buyer_id' => $user->id,
            'item_id' => $purchasedItem->id,
        ]);

        $response = $this->actingAs($user)->get(route('mypage.show'));

        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
        $response->assertSee('avatar.jpg');
        $response->assertSee('出品商品');
        $response->assertSee($purchasedItem->name);
    }

    public function test_profile_edit_form_displays_initial_values()
    {
        $user = User::factory()->create([
            'username' => '初期ユーザー',
            'avatar' => 'initial.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('初期ユーザー');
        $response->assertSee('initial.jpg');
        $response->assertSee('123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル101');
    }
}
