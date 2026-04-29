<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * リクエストの認可
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * 電話番号の結合
     */
    protected function prepareForValidation()
    {
        if ($this->has(['tel1', 'tel2', 'tel3'])) {
            $this->merge([
                'tel' => $this->tel1 . $this->tel2 . $this->tel3,
            ]);
        }
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|integer|in:1,2,3',
            'email' => 'required|email|max:255',
            'tel' => 'required|regex:/^[0-9]+$/',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'detail' => 'required|string|max:120',
        ];
    }

    /**
     * 電話番号 桁数のバリデーション
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $firstName = $this->input('first_name');
            $lastName = $this->input('last_name');

            if (mb_strlen($firstName . $lastName) > 8) {
                $validator->errors()->add('first_name', '名前は姓名合わせて8文字以内で入力してください');
            }
        });

        $validator->after(function ($validator) {
            if (
                collect(['tel1', 'tel2', 'tel3'])
                ->contains(fn($tel) => $this->filled($tel) && strlen($this->$tel) > 5)
            ) {
                $validator->errors()->add('tel', '電話番号は5桁まで入力してください');
            }
        });
    }

    /**
     * バリデーションメッセージ
     */
    public function messages(): array
    {
        return [
            'first_name.required' => '姓を入力してください',
            'last_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel.required' => '電話番号を入力してください',
            'tel.regex' => '電話番号は 半角英数字で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',
        ];
    }

}