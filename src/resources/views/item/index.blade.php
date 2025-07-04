<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
</head>

<body>
    <header class="toppage-header">
        <div class="toppage-header-icon"><x-logo class="w-10 h-10 text-blue-500" /></div>
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
    <div class="tab-container">
        @php
        $tab = request('tab');
        @endphp

        <div class="tab-header">
            <button class="tab {{ $tab === 'mylist' ? '' : 'active' }}" data-tab="recommend">おすすめ</button>
            <button class="tab {{ $tab === 'mylist' ? 'active' : '' }}" data-tab="mylist">マイリスト</button>
        </div>

        <div class="tab-content {{ $tab === 'mylist' ? '' : 'active' }}" id="recommend">
            @if(request('keyword'))
            <p>「{{ request('keyword') }}」の検索結果</p>
            @endif
            @if($products->isEmpty())
            <p class="no-data">現在、商品は登録されていません。</p>
            @else
            <div class="product-list">
                @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <a href="{{ route('item.show', $product->id) }}">
                            <img src="{{ asset('storage/images/' . rawurlencode($product->image_path)) }}" alt="{{ $product->name }}" class="product-image">
                        </a>
                    </div>
                    <div class="product-name">{{ $product->name }}</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="tab-content {{ $tab !== 'mylist' ? 'active' : '' }}" id="mylist">
            @if($mylist->isEmpty())
            <p class="no-data"></p>
            @else
            <div class="product-list">
                @foreach($mylist as $item)
                <div class="product-card">
                    <div class="product-image">
                        <a href="{{ route('item.show', $product->id) }}">
                            <img src="{{ asset('storage/images/' . rawurlencode($item->image_path)) }}" alt="{{ $item->name }}" class="product-image">
                        </a>
                    </div>
                    <div class="product-name">{{ $item->name }}</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
    <script>
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        window.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const selectedTab = params.get('tab');

            if (selectedTab === 'mylist') {
                const activeTab = document.querySelector(`.tab[data-tab="mylist"]`);
                const activeContent = document.getElementById('mylist');

                if (activeTab && activeContent) {
                    tabs.forEach(t => t.classList.remove('active'));
                    contents.forEach(c => c.classList.remove('active'));

                    activeTab.classList.add('active');
                    activeContent.classList.add('active');
                }
            }
        });

        // ユーザー操作によるタブ切り替え
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                contents.forEach(content => content.classList.remove('active'));
                const selected = tab.getAttribute('data-tab');
                document.getElementById(selected).classList.add('active');
            });
        });
    </script>

</body>

</html>