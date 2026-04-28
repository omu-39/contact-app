<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 登録画面を表示できる(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    /** @test */
    public function ユーザー登録ができる(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
        $response->assertRedirect(route('admin.index'));
    }

    /** @test */
    public function すでに登録されているメールアドレスで登録できない(): void
    {
        User::factory()->create([
            'email' => 'duplicate@example.com'
        ]);

        $response = $this->post(route('register'), [
            'name' => 'New User',
            'email' => 'duplicate@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function ログイン画面を表示できる(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    /** @test */
    public function ログインができる(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.index'));
    }

    /** @test */
    public function 間違ったパスワードではログインできない(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function メールアドレスが空だとバリデーションエラーになる(): void
    {
        $response = $this->post(route('login'), [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function パスワードが空だとバリデーションエラーになる(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    /** @test */
    public function ログアウトができる(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function 未認証のユーザーは管理画面にアクセスできずログイン画面にリダイレクトされる(): void
    {
        $response = $this->get(route('admin.index'));

        $response->assertRedirect(route('login'));
    }
}
