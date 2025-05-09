<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'テストユーザー1',
                'password' => Hash::make('password123'),
                'postal_code' => '123-4567',
                'address' => '東京都千代田区1-1-1',
                'building' => 'テストビル101',
            ]
        );

        User::updateOrCreate(
            ['id' => 2],
            [
                'email' => 'test2@example.com',
                'name' => 'テストユーザー2',
                'password' => Hash::make('password123'),
                'postal_code' => '123-4567',
                'address' => '東京都千代田区1-1-2',
                'building' => 'テストビル102',
            ]
        );
    }
}
