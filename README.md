# スクール受講カリキュラム模擬案件１件目　\_フリマアプリ

## お知らせ／現在の状況
現在、一部環境において画像が表示されない問題、およびUIのレイアウト崩れを確認しており、修正対応中です。

## 概要
ユーザーがアイテムの出品と購入を行うためのフリマアプリ

## 開発の背景・目的
一般的なWebシステムの基本機能（CRUD処理、ユーザー認証、データベース連携）の全体像と、プログラムが動く構造への理解を深めることを最優先の目的として制作しました。
開発を通して、複雑な処理を段階的に記述する難しさを学び、現在は「ただ動くだけでなく、他者が読みやすく、エラーの原因を特定しやすいコード設計」の重要性を意識した学習・リファクタリングに取り組んでいます。

## 主要機能
*   **会員管理機能**（新規登録、ログイン、ログアウト）
*   **プロフィール表示・編集機能**（プロフィール画像、ユーザー名、出品商品一覧、購入商品一覧、）
*   **商品管理機能**（新規出品、詳細表示）
*   **商品購入機能**
*   **画像アップロード機能**
*   **検索機能**
*   **コメント機能**
  
## 使用技術（技術スタック）
*  **開発言語**：PHP
*  **フレームワーク**：Laravel
*  **データーベース**：MySQL
*  **バージョン管理**：Docker, GitHub

## 環境構築手順

### Docker ビルド

1.イメージをビルドする。

    docker-compose up -d --build

### Laravel 環境構築

1.docker コンテナに接続する。

    docker-compose exec php bash

2.必要なパッケージをインストールする。

    composer install

3.プロジェクトのルート（/var/www/）で以下のコマンドを使い、『.env.example』をコピー名前変更し『.env』を作成。

      cp .env.example .env

『.env』ファイルの　 11 行目あたりを以下のように編集。

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


## Stripe の設定方法

　　このアプリでは決済機能に Stripe を使用しています。

　　ローカルで動かす場合は、以下の設定が必要です。

1. Stripe SDK のインストール

    composer require stripe/stripe-php

2. .env に Stripe のキーを追加

    Stripe ダッシュボードから自分のテストキーをコピーして、.env に貼ってください。

        STRIPE_KEY=pk_test_xxxxxxxxx
        STRIPE_SECRET=sk_test_xxxxxxxxx

3. キャッシュのクリア（必要な場合のみ）

    php artisan config:clear


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


   

