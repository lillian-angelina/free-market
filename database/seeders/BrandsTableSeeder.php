<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('brands')->insert([
            ['name' => 'Nike'],
            ['name' => 'Adidas'],
            ['name' => 'UNIQLO'],
            ['name' => 'ZARA'],
            ['name' => 'GU'],
            ['name' => 'その他'],
        ]);
    }
}
