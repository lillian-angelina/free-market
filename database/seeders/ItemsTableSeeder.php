<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        // user_id = 1 のユーザーに商品を5件紐づけて登録
        for ($i = 1; $i <= 5; $i++) {
            Item::create([
                'user_id' => 1,
                'name' => "商品タイトル $i",
                'description' => "これは商品 $i の説明です。",
                'price' => rand(500, 5000),
                'image_path' => null,
            ]);
        }
    }
}
