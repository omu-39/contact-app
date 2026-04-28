<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class RegistrationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function 登録画面を表示できる(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    /** @test */
    public function 新規ユーザー登録ができる(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
        $response->assertRedirect(route('admin.index'));
    }

    /** @test */
    public function 名前が空だとバリデーションエラーになる(): void
    {
        $response = $this->post(route('register'), [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** @test */
    public function メールアドレスが空だとバリデーションエラーになる(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function 無効なメールアドレス形式だとバリデーションエラーになる(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function すでに登録されているメールアドレスだとバリデーションエラーになる(): void
    {
        User::factory()->create([
            'email' => 'duplicate@example.com'
        ]);

        $response = $this->post(route('register'), [
            'name' => 'New User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}
