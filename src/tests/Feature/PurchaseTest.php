<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\ItemCondition;
use App\Models\Order;
use App\Models\PaymentMethod;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_purchase_item()
    {
        // 前提：購入者ユーザー、出品者ユーザー、商品状態、支払い方法を用意
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $condition = ItemCondition::factory()->create(['name' => '新品']);
        $method = PaymentMethod::factory()->create(['name' => 'クレジットカード']);
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'price' => 1000,
            'is_sold' => false,
        ]);

        // 購入ページへ遷移
        $response = $this->actingAs($buyer)
            ->get(route('purchase.index', $item->id));
        $response->assertStatus(200)
            ->assertSee('¥' . number_format($item->price));

        // 購入を実行
        $response = $this->actingAs($buyer)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => $method->name,
            ]);

        // 注文テーブルに記録される
        $this->assertDatabaseHas('orders', [
            'buyer_id' => $buyer->id,
            'item_id' => $item->id,
            'payment_method_id' => $method->id,
        ]);

        // 商品テーブルで is_sold が true になる
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);

        // 購入後リダイレクト、購入完了ページへ
        $response->assertRedirect(route('checkout.success'));
    }

    public function test_sold_item_shows_sold_on_index()
    {
        $buyer = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);
        $seller = User::factory()->create();
        $condition = ItemCondition::factory()->create();
        $payment = PaymentMethod::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'price' => 2000,
            'is_sold' => false,
        ]);

        // 購入処理
        $this->actingAs($buyer)->post(route('purchase.store', $item->id), [
            'payment_method' => $payment->name,
        ]);

        // 最新の状態を取得
        $item->refresh();
        $this->assertTrue((bool) $item->is_sold);

        // ホーム画面に「SOLD」ラベルが表示されることを確認
        $response = $this->actingAs($buyer)->get(route('home'));
        $response->assertSee('SOLD'); // ← assertSeeText → assertSee に変更も有効
    }

    public function test_purchased_item_appears_in_user_profile()
    {
        $buyer = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);
        $seller = User::factory()->create();
        $condition = ItemCondition::factory()->create();
        $payment = PaymentMethod::factory()->create([
            'name' => 'クレジットカード',
        ]);
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'user_id' => $seller->id,
            'condition_id' => $condition->id,
            'price' => 3000,
            'is_sold' => false,
        ]);

        // 購入実行
        $response = $this->actingAs($buyer)->post(route('purchase.store', $item->id), [
            'payment_method' => 'クレジットカード',
            'shipping_address' => 'サンプル住所',
        ]);

        $this->assertDatabaseHas('orders', [
            'buyer_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response->assertStatus(302);

        // マイページに購入済み商品として表示される
        $response = $this->actingAs($buyer)->get(route('mypage.show', ['tab' => 'mylist']));
        $response->assertStatus(200);
        $response->assertSee($item->name);
    }
}
