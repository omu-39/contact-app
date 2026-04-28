<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;


class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ユーザーは管理画面を表示できる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $user = User::factory()->create();
        Contact::factory()->count(10)->create();

        $response = $this->actingAs($user)->get(route('admin.index'));

        $response->assertStatus(200);
        $response->assertViewHas('contacts');
    }

    /** @test */
    public function ユーザーはモーダルでお問い合わせの詳細を取得できる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $user = User::factory()->create();
        $contact = Contact::factory()->create([
            'detail' => 'これはモーダル内に表示されるべき詳細メッセージです'
        ]);

        $response = $this->actingAs($user)->get(route('admin.index'));

        $response->assertStatus(200);
        // HTML内に全データの詳細が含まれていることを確認
        $response->assertSee('これはモーダル内に表示されるべき詳細メッセージです');
    }

    /** @test */
    public function ユーザーはお問い合わせを削除できる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $user = User::factory()->create();
        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.delete', $contact));

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
        $response->assertRedirect(route('admin.index'));
    }

    /** @test */
    public function ユーザーは検索機能を使ってお問い合わせの絞込ができる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $user = User::factory()->create();

        $target = Contact::factory()->create([
            'last_name' => '山田',
            'first_name' => '太郎',
            'email' => 'target@example.com'
        ]);
        $other = Contact::factory()->create([
            'last_name' => '佐藤',
            'first_name' => '花子',
            'email' => 'other@example.com'
        ]);

        $response = $this->actingAs($user)->get(route('admin.search', ['keyword' => '山田太郎']));

        $response->assertStatus(200);
        $response->assertSee('target@example.com');
        $response->assertDontSee('other@example.com');
    }

    /** @test */
    public function ユーザーはエクスポートボタンを押してお問い合わせ一覧のcsvデータを取得できる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $user = User::factory()->create();

        // 検索対象
        $target = Contact::factory()->create([
            'last_name' => '山田',
            'first_name' => '太郎',
            'email' => 'yamada@example.com'
        ]);
        // 除外対象
        $other = Contact::factory()->create([
            'last_name' => '佐藤',
            'email' => 'sato@example.com'
        ]);

        // 検索条件付きでエクスポートを実行
        $response = $this->actingAs($user)->get(route('admin.export', ['keyword' => '山田']));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $content = $response->streamedContent();
        $this->assertStringContainsString('yamada@example.com', $content);
        $this->assertStringNotContainsString('sato@example.com', $content);
    }

    /** @test */
    public function 未認証ユーザーは削除を実行できずログイン画面にリダイレクトされる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->create();

        $response = $this->delete(route('admin.delete', $contact));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('contacts', ['id' => $contact->id]);
    }

    /** @test */
    public function 未認証ユーザーはcsvエクスポートを実行できずログイン画面にリダイレクトされる(): void
    {
        $response = $this->get(route('admin.export'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function 存在しないお問い合わせを削除しようとすると404エラーになる(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/admin/delete/999');

        $response->assertStatus(404);
    }

    /** @test */
    public function 不正な検索パラメータが送られてもシステムエラーにならない(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $user = User::factory()->create();
        Contact::factory()->create(['gender' => 1]);

        $response = $this->actingAs($user)->get(route('admin.search', [
            'gender' => '99',
            'date' => 'not-a-date'
        ]));

        $response->assertStatus(200);
    }
}
