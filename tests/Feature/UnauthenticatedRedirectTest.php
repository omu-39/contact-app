<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnauthenticatedRedirectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 未認証のユーザーは管理画面にアクセスするとログイン画面にリダイレクトされる(): void
    {
        $response = $this->get(route('admin.index'));

        $response->assertRedirect(route('login'));
    }
}
