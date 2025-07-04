<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTEC</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/item_show.css') }}">
</head>

<body>
    <header class="toppage-header">
        <a href="/">
            <div class="toppage-header-icon"><x-logo class="w-10 h-10 text-blue-500" /></div>
        </a>
        <div class="toppage-header-search"><input type="text" class="input-text" placeholder="なにをお探しですか？"></div>
        <div class="toppage-header-nav">
            <a class="toppage-header-login" href="">ログアウト</a>
            <a class="toppage-header-mypage" href="">マイページ</a>
            <a class="toppage-header-cart" href="">出品</a>
        </div>
    </header>
    <main class="item-show">
        <div class="item-show-left">
            <img class="show-img" src="" alt="商品画像">
        </div>
        <div class="item-show-right">
            <div class="item-details">
                <h1 class="item-name">商品名がここに入る</h1>
                <p class="item-brand">ブランド名</p>
                <h2>¥00,000（税込）</h2>
                <div class="show-product-actions">
                    <div class="show-icon-group">
                        <img class="show-icon" src="/storage/images/nice.png" alt="評価の星">
                        <p class="show-icon-numbers">0</p>
                    </div>
                    <div class="show-icon-group">
                        <img class="show-icon" src="/storage/images/like.png" alt="いいねアイコン">
                        <p class="show-icon-numbers">0</p>
                    </div>
                </div>
                <a class="show-purchase" href="">購入手続きへ</a>

                <p class="show-subtitle">商品説明 </p>
                <p>ここに商品の説明が入ります。</p>
                <p class="show-subtitle">商品の情報</p>
                <p class="information-title">カテゴリー</p>
                <p class="information-title">商品の状態</p>

            </div>
            <div class="comments">
                <p class="comments-title">コメント（{{ count($comments) }}）</p>

                @foreach ($comments as $comment)
                <div class="comment">
                    <div class="comment-header">
                        <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="avatar" class="avatar">
                        <p class="username">{{ $comment->user->name }}</p>
                    </div>
                    <p class="comment-content">{{ $comment->content }}</p>
                </div>
                @endforeach

                <form class="comment-form" action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <p class="comment-form-title">商品へのコメント</p>
                    <textarea class="comment-textarea" name="content" required></textarea>
                    <button class="show-button" type="submit">コメントを送信する</button>
                </form>
            </div>

        </div>
    </main>
</body>

</html>