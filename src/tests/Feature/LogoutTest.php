<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_logout_successfully()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        // ログイン状態にする
        $response = $this->actingAs($user);

        // ログアウト処理
        $response = $this->post('/logout');

        // 認証解除されていることを確認
        $this->assertGuest();
    }
}
