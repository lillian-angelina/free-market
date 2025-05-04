<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'user_id' => 1,
                'name' => "腕時計",
                'description' => "スタイリッシュなデザインのメンズ腕時計",
                'price' => 15000,
                'condition' => '良好',
                'brand_name' => 'SEIKO',
                'image_path' => 'images/Clock.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "HDD",
                'description' => "高速で信頼性の高いハードディスク",
                'price' => 5000,
                'condition' => '目立った傷や汚れなし',
                'brand_name' => 'Western Digital',
                'image_path' => 'images/HDD.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "玉ねぎ3束",
                'description' => "新鮮な玉ねぎ3束のセット",
                'price' => 300,
                'condition' => 'やや傷や汚れあり',
                'brand_name' => null,
                'image_path' => 'images/iLoveIMG.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "革靴",
                'description' => "クラシックなデザインの革靴",
                'price' => 4000,
                'condition' => '状態が悪い',
                'brand_name' => 'REGAL',
                'image_path' => 'images/Shoes.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "ノートPC",
                'description' => "高性能なノートパソコン",
                'price' => 45000,
                'condition' => '良好',
                'brand_name' => 'DELL',
                'image_path' => 'images/NPC.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "マイク",
                'description' => "高音質のレコーディング用マイク",
                'price' => 8000,
                'condition' => '目立った傷や汚れなし',
                'brand_name' => 'SHURE',
                'image_path' => 'images/Mic.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "ショルダーバッグ",
                'description' => "おしゃれなショルダーバッグ",
                'price' => 3500,
                'condition' => 'やや傷や汚れあり',
                'brand_name' => 'PORTER',
                'image_path' => 'images/bag.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "タンブラー",
                'description' => "使いやすいタンブラー",
                'price' => 500,
                'condition' => '状態が悪い',
                'brand_name' => 'THERMOS',
                'image_path' => 'images/Tumbler.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "コーヒーミル",
                'description' => "手動のコーヒーミル",
                'price' => 4000,
                'condition' => '良好',
                'brand_name' => 'Kalita',
                'image_path' => 'images/Coffee.jpg',
            ],
            [
                'user_id' => 1,
                'name' => "メイクセット",
                'description' => "便利なメイクアップセット",
                'price' => 2500,
                'condition' => '目立った傷や汚れなし',
                'brand_name' => null,
                'image_path' => 'images/外出メイクアップセット.jpg',
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
