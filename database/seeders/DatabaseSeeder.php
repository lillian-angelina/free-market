<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\ItemsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'zipcode' => '123-4567',
            'address' => '東京都千代田区1-1-1',
            'building' => 'テストビル101',
        ]);

        $this->call([
            UsersTableSeeder::class,
            ItemsTableSeeder::class,
            BrandsTableSeeder::class,
            CategoriesTableSeeder::class,
        ]);
    }
}
