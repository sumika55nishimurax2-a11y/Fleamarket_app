
# 模擬案件　_フリマアプリ

## 環境構築

### Docker ビルド

  1.     docker-compose up -d --build

### Laravel 環境構築

  1.     docker-compose exec php bash

  2.     composer install

  3. 『.env.example』をコピー名前変更し『.env』を作成。70行目あたりを以下のように編集

 
    // 前略
    DB_CONNECTION=mysql
    DB_HOST=mysql
    DB_PORT=3306
    DB_DATABASE=laravel_db
    DB_USERNAME=laravel_user
    B_PASSWORD=laravel_pass
    // 後略

  5.アプリキーを作成

    php artisan key:generate

  6.マイグレーション実行

    php artisan migrate

  7.シーディング実行

    php artisan db:seed

## 使用技術（実行環境）

 + PHP7.4.9-fpm
  
 + Laravel8.83.29
  
 + MySQL8.0.26

## ER 図

![furimaAppER](https://github.com/user-attachments/assets/a19fa6d4-f12d-46a9-9627-7f8dca5cce23)




## URL

 + 開発環境：http://localhost/

 + phpMyadmin：http://localhost:8080/


## そのほか

### テストユーザーデータ

+ username

  1 山田たろう

  2 田中はなこ

+ email

  1  test@example.com

  2  test2@example.com

+ password

  1  12345678

  2  1234abcd

+ avatar

  1　

  2  

+ postal_code

  1

  2

+ address

  1

  2

+ building

  1

  2

