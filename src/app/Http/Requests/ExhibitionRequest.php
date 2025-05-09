<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'categories' => 'required|array',
            'condition' => 'required|string',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください。',
            'image.image' => '画像ファイル形式でアップロードしてください。',
            'image.max' => '画像サイズは2MB以下にしてください。',

            'categories.required' => '少なくとも1つカテゴリを選択してください。',
            'condition.required' => '商品の状態を選択してください。',

            'name.required' => '商品名を入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',

            'brand.max' => 'ブランド名は255文字以内で入力してください。',

            'description.required' => '商品の説明を入力してください。',

            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は整数で入力してください。',
            'price.min' => '販売価格は1円以上にしてください。',
        ];
    }
}
