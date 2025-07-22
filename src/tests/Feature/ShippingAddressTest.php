<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ShippingAddressTest extends TestCase
{
    use DatabaseMigrations;

    public function test_updated_shipping_address_is_reflected_on_purchase_page()
    {
        $user = User::factory()->create([
            'postal_code' => '000-0000',
            'address' => '旧住所',
            'building' => '旧ビル',
        ]);

        $item = Item::factory()->create();

        // ログイン状態を保ったまま住所変更
        $this->actingAs($user)
            ->post(route('purchase.address.update', ['item' => $item->id]), [
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区',
                'building' => 'テストビル101',
            ]);

        // ユーザー情報を再取得（DBから最新に）
        $user = $user->fresh();

        // 同じユーザーで再アクセス
        $response = $this->actingAs($user)->get(route('purchase.index', $item->id));

        $response->assertStatus(200);
        $response->assertSee('〒123-4567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル101');
    }
    /** @test */
    public function shipping_address_is_stored_in_order_after_purchase()
    {
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101'
        ]);

        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'is_sold' => false,
        ]);
        $paymentMethod = PaymentMethod::factory()->create(['name' => 'クレジットカード']);

        // 購入処理
        $this->actingAs($user)->post(route('purchase.store', $item->id), [
            'payment_method' => 'クレジットカード',
        ]);

        // ordersテーブルに保存された住所を確認
        $this->assertDatabaseHas('orders', [
            'buyer_id' => $user->id,
            'item_id' => $item->id,
            'shipping_address' => '123-4567 東京都渋谷区 テストビル101',
        ]);
    }
}
