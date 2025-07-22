<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test 名前が未入力の場合、バリデーションエラーになる */
    public function test_name_is_required()
    {
        $response = $this->post('/register', [
            'username' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'username' => 'お名前を入力してください',
        ]);
    }

    /** @test メールアドレスが未入力の場合、バリデーションエラーになる */
    public function test_email_is_required()
    {
        $response = $this->post('/register', [
            'username' => 'テスト太郎',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    /** @test パスワードが未入力の場合、バリデーションエラーになる */
    public function test_password_is_required()
    {
        $response = $this->post('/register', [
            'username' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    /** @test パスワードが7文字以下の場合、バリデーションエラーになる */
    public function test_password_must_be_at_least_8_characters()
    {
        $response = $this->post('/register', [
            'username' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    /** @test パスワード確認と一致しない場合、バリデーションエラーになる */
    public function test_password_confirmation_must_match()
    {
        $response = $this->post('/register', [
            'username' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertSessionHasErrors([
            'password_confirmation' => 'パスワードと一致しません',
        ]);
    }

    /** @test 正しい情報を入力した場合、登録処理が成功しログイン画面に遷移する */
    public function test_user_can_register_successfully()
    {
        $response = $this->post('/register', [
            'username' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/email/verify');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}
