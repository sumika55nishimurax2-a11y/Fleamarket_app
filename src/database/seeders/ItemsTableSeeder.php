<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        // 腕時計
        $item = Item::create([
            'user_id' => 1,
            'name' => '腕時計',
            'brand' => 'Armani',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => 'Armani+Mens+Clock.jpg',
            'condition_id' => 1,
        ]);
        $item->categories()->attach([1, 5]); // ファッション, メンズ

        // HDD
        $item = Item::create([
            'user_id' => 1,
            'name' => 'HDD',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'HDD+Hard+Disk.jpg',
            'condition_id' => 2,
        ]);
        $item->categories()->attach([2]); // 家電

        // 玉ねぎ3束
        $item = Item::create([
            'user_id' => 2,
            'name' => '玉ねぎ3束',
            'price' => 300,
            'description' => '新鮮な玉ねぎ3束セット',
            'image_path' => 'Onion+Bundle.jpg',
            'condition_id' => 3,
        ]);
        $item->categories()->attach([11]); // キッチン

        // 革靴
        $item = Item::create([
            'user_id' => 1,
            'name' => '革靴',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'image_path' => 'Leather+Shoes+Product+Photo.jpg',
            'condition_id' => 4,
        ]);
        $item->categories()->attach([1, 5]); // ファッション, メンズ

        // ノートPC
        $item = Item::create([
            'user_id' => 1,
            'name' => 'ノートPC',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'image_path' => 'Living+Room+Laptop.jpg',
            'condition_id' => 1,
        ]);
        $item->categories()->attach([2]); // 家電

        // マイク
        $item = Item::create([
            'user_id' => 1,
            'name' => 'マイク',
            'price' => 8000,
            'description' => '高音質のレコーディング用マイク',
            'image_path' => 'Music+Mic+4632231.jpg',
            'condition_id' => 2,
        ]);
        $item->categories()->attach([2]); // 家電

        // ショルダーバッグ
        $item = Item::create([
            'user_id' => 2,
            'name' => 'ショルダーバッグ',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'image_path' => 'Purse+fashion+pocket.jpg',
            'condition_id' => 3,
        ]);
        $item->categories()->attach([1, 4]); // ファッション, レディース

        // タンブラー
        $item = Item::create([
            'user_id' => 2,
            'name' => 'タンブラー',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'image_path' => 'Tumbler+souvenir.jpg',
            'condition_id' => 4,
        ]);
        $item->categories()->attach([10]); // キッチン

        // コーヒーミル
        $item = Item::create([
            'user_id' => 1,
            'name' => 'コーヒーミル',
            'price' => 4000,
            'description' => '手動のコーヒーミル',
            'image_path' => 'Waitress+with+Coffee+Grinder.jpg',
            'condition_id' => 1,
        ]);
        $item->categories()->attach([10]); // キッチン

        // メイクセット
        $item = Item::create([
            'user_id' => 2,
            'name' => 'メイクセット',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'image_path' => 'cosmetics.jpg',
            'condition_id' => 2,
        ]);
        $item->categories()->attach([6]); // コスメ
    }
}
