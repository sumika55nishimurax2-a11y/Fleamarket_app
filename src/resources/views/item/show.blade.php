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
        <form method="GET" action="{{ route('home') }}" class="toppage-header-search">
            <input type="text" name="keyword" class="input-text" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
        </form>

        <div class="toppage-header-nav">
            @auth

            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
            <a href="#" class="toppage-header-logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログアウト
            </a>
            @else
            <a class="toppage-header-login" href="{{ route('login') }}">ログイン</a>
            @endauth

            <a class="toppage-header-mypage" href="{{ route('mypage.show') }}">マイページ</a>
            <a class="toppage-header-cart" href="{{ route('item.create') }}">出品</a>
        </div>
    </header>
    <main class="item-show">
        <div class="item-show-left">
            <img class="show-img" src="{{ asset('storage/' . $item->image_path) }}" alt="商品画像">
        </div>
        <div class="item-show-right">
            <div class="item-details">
                <h1 class="item-name">{{ $item->name }}</h1>
                <p class="item-brand">{{ $item->brand }}</p>
                <h2>¥{{ number_format($item->price) }}（税込）</h2>
                <div class="show-product-actions">
                    @auth
                    <form class="show-icon-group" method="POST" action="{{ route('items.like', $item->id) }}">
                        @csrf
                        <button type="submit" class="like-button" style="background: none; border: none;">
                            <div class="like-icon-container">
                                <div class="show-icon-nice">
                                    <x-niceicon class="nice-icon {{ $item->isLikedBy(auth()->user()) ? 'liked' : '' }}" />
                                </div>
                                <p class="show-icon-numbers">{{ $item->likes->count() }}</p>
                            </div>
                        </button>
                    </form>
                    @else
                    <div class="show-icon-group">
                        <div class="like-icon-container">
                            <div class="show-icon-nice">
                                <x-niceicon class="nice-icon" />
                            </div>
                            <p class="show-icon-numbers">{{ $item->likes->count() }}</p>
                        </div>
                    </div>
                    @endauth
                    <div class="show-icon-group">
                        <div class="like-icon-container">
                            <img class="show-icon" src="/storage/images/like.png" alt="コメント数">
                            <p class="show-icon-numbers">{{ count($comments) }}</p>
                        </div>
                    </div>
                </div>
                @auth
                <a class="show-purchase" href="{{ route('purchase.index', $item->id) }}">購入手続きへ</a>
                @else
                <a class="show-purchase" href="{{ route('login') }}">購入手続きへ</a>
                @endauth

                <p class=" show-subtitle">商品説明 </p>
                <p>{{ $item->description }}</p>
                <p class="show-subtitle">商品の情報</p>
                <div class="information-line">
                    <span class="information-title">カテゴリー</span>
                    @foreach ($item->categories as $category)
                    <span class="category-label">{{ $category->name }}</span>
                    @endforeach
                </div>
                <div class="information-line">
                    <span class="information-title">商品の状態</span>
                    <span class="condition-label">{{ $item->condition->name }}</span>
                </div>

            </div>
            <div class="comments">
                <p class="comments-title">コメント（{{ count($comments) }}）</p>

                @foreach ($comments as $comment)
                <div class="comment">
                    <div class="comment-header">
                        <img src="{{ asset('storage/' . $comment->user->avatar) }}" alt="avatar" class="avatar">
                        <p class="username">{{ $comment->user->username }}</p>
                    </div>
                    <p class="comment-content">{{ $comment->comment }}</p>
                </div>
                @endforeach

                @auth
                <form class="comment-form" action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <p class="comment-form-title">商品へのコメント</p>
                    <textarea class="comment-textarea" name="comment" required></textarea>
                    <button class="show-button" type="submit">コメントを送信する</button>
                </form>
                @else
                <p class="comment-form-title">商品へのコメント</p>
                <textarea class="comment-textarea" name="comment" required></textarea>
                <button class="show-button" type="submit">コメントを送信する</button>
                <p class="comment-form-title">※コメントするには <a href="{{ route('login') }}">ログイン</a> してください</p>
                @endauth
            </div>

        </div>
    </main>
</body>

</html>