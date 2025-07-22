<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_method_is_displayed_on_checkout_screen()
    {
        // ユーザー・商品・支払い方法の用意
        $user = User::factory()->create([
            'postal_code' => '123-4567',
            'address' => '東京都渋谷区',
            'building' => 'テストビル101',
        ]);
        $item = Item::factory()->create(['user_id' => User::factory()->create()->id]);
        $paymentMethod = PaymentMethod::factory()->create(['name' => 'クレジットカード']);

        // 購入画面へアクセス（GET）
        $response = $this->actingAs($user)->get(route('purchase.index', ['item' => $item->id]));

        $response->assertStatus(200);

        // 支払い方法として「クレジットカード」がHTML内に表示されていることを確認
        $response->assertSee('<option value="クレジットカード">クレジットカード</option>', false);
    }
}
