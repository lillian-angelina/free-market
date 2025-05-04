<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 認証済みユーザー前提
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'image' => 'nullable|file|mimes:jpeg,png|max:2048', // 拡張子チェック
        ];
    }

    public function messages()
    {
        return [
            'image.mimes' => 'プロフィール画像は.jpegまたは.png形式でアップロードしてください。',
            'image.max' => 'プロフィール画像のサイズは2MB以内にしてください。',
        ];
    }
}
