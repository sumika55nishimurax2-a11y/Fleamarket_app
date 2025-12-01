# 模擬案件　\_フリマアプリ

## 環境構築

### Docker ビルド

1.                docker-compose up -d --build

### Laravel 環境構築

1.                docker-compose exec php bash

2.                composer install

3.  『.env.example』をコピー名前変更し『.env』を作成。11 行目あたりを以下のように編集

            / 前略
            DB_CONNECTION=mysql
            DB_HOST=mysql
            DB_PORT=3306
            DB_DATABASE=laravel_db
            DB_USERNAME=laravel_user
            DB_PASSWORD=laravel_pass
            // 後略

5.アプリキーを作成

    php artisan key:generate

6.マイグレーション実行

    php artisan migrate

7.シーディング実行

    php artisan db:seed

## stripe 　 SDK のインストール

composer require stripe/stripe-php

- .env にキー追加

  STRIPE\*KEY=pk\*test\*\*\*\*

  STRIPE\*SECRET=sk_test\*\_\*\*

## 使用技術（実行環境）

- PHP8.2.29

- Laravel10.48.29

- MySQL8.0.26

## 使用技術（メール認証）

- mailhog

## ER 図

![furimaAppER](https://github.com/user-attachments/assets/a19fa6d4-f12d-46a9-9627-7f8dca5cce23)

## URL

- 開発環境：http://localhost/

- phpMyadmin：http://localhost:8080/

- mailhog:http://localhost:8025/

## そのほか

### テストユーザーデータ

- username

  1 山田たろう

  2 田中はなこ

- email

  1 test@example.com

  2 test2@example.com

- password

  1 12345678

  2 1234abcd



## 決済画面カード支払いテスト用情報

    - カード番号: 4242 4242 4242 4242

    - 有効期限: 任意の未来日（例: 12/34）

    - CVC: 任意の 3 桁（例: 123）


***

# 単体テストについて

 1. .env.testing の準備

     このリポジトリにはテスト用の設定ファイル .env.testing が含まれています。

     クローン後、必要であれば 自分の環境に合わせてデータベース名・ユーザー名・パスワードだけ変更 してください。

2. テスト用データベースを作る

     テスト専用のデータベースを自分のパソコンに作ります。

        php artisan migrate --env=testing


3. テストを実行する

     テスト実行コマンド

        php artisan test


   

