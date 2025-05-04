<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証済みユーザーのみ許可する場合は別途認証チェック
    }

    public function rules()
    {
        return [
            'postal_code' => 'required|string|max:10',
            'prefecture' => 'required|string|max:255',
            'building' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'postal_code.required' => '郵便番号を入力してください。',
            'prefecture.required' => '住所を入力してください。',
            'building.required' => '建物名を入力してください。',
        ];
    }
}
