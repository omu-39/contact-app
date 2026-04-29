<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'email' => 'required|email',
                'password' => 'required',
            ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'password.required' => 'パスワードを入力してください',
        ];
    }

    public function withValidator(Validator $validator) {
        $validator->after(function (Validator $validator) {
            $user = User::where('email', $this->email)->first();

            if (!$user || !Hash::check($this->password, $user->password)) {
                $validator->errors()->add('password', 'ログイン情報が登録されていません');
            }
        });
    }
}
