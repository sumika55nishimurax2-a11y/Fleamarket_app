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
        <a href="/">
            <div class="toppage-header-icon"><x-logo class="w-10 h-10 text-blue-500" /></div>
        </a>
        <form method="GET" action="{{ route('home') }}" class="toppage-header-search">
            <input type="hidden" name="tab" value="{{ request('tab', 'recommend') }}">
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
            @if($products->isEmpty())
            <p class="no-data">おすすめ商品はありません。</p>
            @else
            <div class="product-list">
                @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <a href="{{ route('items.show', $product->id) }}">
                            <img src="{{ asset('storage/' . rawurlencode($product->image_path)) }}" alt="{{ $product->name }}" class="product-image">
                            @if ($product->is_sold === 1)
                            <p class="sold-label">SOLD</p>
                            @endif
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
                        <a href="{{ route('items.show', $item->id) }}">
                            <img src="{{ asset('storage/' . rawurlencode($item->image_path)) }}" alt="{{ $item->name }}" class="product-image">
                            @if ($item->is_sold === 1)
                            <div class="sold-label">SOLD</div>
                            @endif
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

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const selected = tab.getAttribute('data-tab');
                document.querySelector('input[name="tab"]').value = selected;

                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                contents.forEach(content => content.classList.remove('active'));
                document.getElementById(selected).classList.add('active');
            });
        });
    </script>

</body>

</html>