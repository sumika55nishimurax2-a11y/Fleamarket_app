<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageFixtureSeeder extends Seeder
{
    public function run(): void
    {
        // fixtures ディレクトリの定義
        $map = [
            'images'  => database_path('seeders/fixtures/images'),
            'avatars' => database_path('seeders/fixtures/avatars'),
        ];

        foreach ($map as $dir => $srcPath) {

            // fixtures ディレクトリが存在しなければスキップ
            if (!is_dir($srcPath)) {
                continue;
            }

            // Storage 側のコピー先（例: storage/app/public/images）
            $dstPath = Storage::disk('public')->path($dir);

            // ディレクトリを確実に作成
            File::ensureDirectoryExists($dstPath);

            // fixtures 内のファイルを全コピー
            foreach (File::files($srcPath) as $file) {
                $filename = $file->getFilename();
                File::copy($file->getPathname(), $dstPath . DIRECTORY_SEPARATOR . $filename);
            }
        }
    }
}
