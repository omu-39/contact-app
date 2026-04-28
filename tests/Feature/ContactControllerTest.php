<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Contact;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ユーザーはお問い合わせフォームを表示できる(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('contact.create');
    }

    /** @test */
    public function ユーザーはお問い合わせ内容の確認が出来る(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make()->toArray();

        $postData = array_merge($contact, [
            'tel1' => '080',
            'tel2' => '1234',
            'tel3' => '5678',
        ]);
        unset($postData['tel']);

        $response = $this->post(route('contact.confirm'), $postData);

        $response->assertStatus(200);
        $response->assertViewIs('contact.confirm');

        $expected = array_merge($contact, ['tel' => '08012345678']);
        $response->assertSessionHas('inputs', $expected);
    }

    /** @test */
    public function DBにデータが保存され、サンクスページが表示される(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make()->toArray();
        session(['inputs' => $contact]);

        $response = $this->post(route('contact.store'));

        $this->assertDatabaseHas('contacts', ['email' => $contact['email']]);
        $response->assertRedirect(route('contact.thanks'));
    }

    /** @test */
    public function ユーザーは修正ボタンを押して入力値が保持された状態の入力画面に戻れる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make()->toArray();
        session(['inputs' => $contact]);

        $response = $this->post(route('contact.store'), ['back' => true]);

        $response->assertRedirect(route('contact.create'));
        $response->assertSessionHas('_old_input');
    }

    /** @test */
    public function 名前は姓名合わせて8文字まで入力できる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make([
            'first_name' => '山田',
            'last_name'  => '太郎次郎三郎',
        ])->toArray();
        $contact['tel1'] = '080';
        $contact['tel2'] = '1234';
        $contact['tel3'] = '5678';

        $response = $this->post(route('contact.confirm'), $contact);

        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function 名前は姓名合わせて8文字を超えるバリデーションエラーになる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make([
            'first_name' => '山田',
            'last_name'  => '太郎次郎三郎四',
        ])->toArray();
        $contact['tel1'] = '080';
        $contact['tel2'] = '1234';
        $contact['tel3'] = '5678';

        $response = $this->post(route('contact.confirm'), $contact);

        $response->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    public function 電話番号のデータが結合されて保存されている(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make()->toArray();
        $contact = array_merge($contact, [
            'tel1' => '080',
            'tel2' => '1234',
            'tel3' => '5678',
        ]);

        $this->post(route('contact.confirm'), $contact);
        $this->post(route('contact.store'));

        $this->assertDatabaseHas('contacts', [
            'tel' => '08012345678'
        ]);
    }

    /** @test */
    public function 電話番号の各項目は5桁まで入力できる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make()->toArray();
        $contact = array_merge($contact, [
            'tel1' => '12345',
            'tel2' => '12345',
            'tel3' => '12345',
        ]);

        $response = $this->post(route('contact.confirm'), $contact);

        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function 電話番号の各項目はいずれかが5桁を超えるとバリデーションエラーになる(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make()->toArray();
        $contact = array_merge($contact, [
            'tel1' => '123456',
            'tel2' => '12345',
            'tel3' => '12345',
        ]);

        $response = $this->post(route('contact.confirm'), $contact);

        $response->assertSessionHasErrors(['tel']);
    }

    /** @test */
    public function DBに無いカテゴリーは使用できない(): void
    {
        $this->seed(\Database\Seeders\CategorySeeder::class);
        $contact = Contact::factory()->make([
            'category_id' => 999,
        ])->toArray();
        $contact['tel1'] = '080';
        $contact['tel2'] = '1234';
        $contact['tel3'] = '5678';

        $response = $this->post(route('contact.confirm'), $contact);

        $response->assertSessionHasErrors(['category_id']);
    }
}
