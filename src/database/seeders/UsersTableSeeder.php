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
        ]);

        DB::table('users')->insert([
            'username' => '田中はなこ',
            'email' => 'test2@example.com',
            'password' => Hash::make('1234abcd'),
        ]);
    }
}
