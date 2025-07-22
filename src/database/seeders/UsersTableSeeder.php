<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => '山田たろう',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
            'email_verified' => true,
            'avatar' => 'avatars/U2yjg9Zt3DAiTKJn4pxXp2TUjOzyc9GZ8NTvZHiT.png',
            'postal_code' => '123-4567',
            'address' => '東京都新宿区1-2-3',
            'building' => 'テストビル101',
        ]);

        DB::table('users')->insert([
            'username' => '田中はなこ',
            'email' => 'test2@example.com',
            'password' => Hash::make('1234abcd'),
            'avatar' => 'avatars/AYIzmf6EciRgH5hG46yocVxPo2oIZrYJ3dAvtGWH.png',
            'email_verified' => true,
            'postal_code' => '987-6543',
            'address' => '大阪府大阪市北区4-5-6',
        ]);
    }
}
