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
            <a href="#" class="toppage-header-logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログアウト
            </a>

            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
            <a class="toppage-header-mypage" href="{{ route('mypage.show') }}">マイページ</a>
            <a class="toppage-header-cart" href="{{ route('item.create') }}">出品</a>
        </div>
    </header>

    <div class="mypage">
        <img class="image" src="{{ asset('storage/' . ($user->avatar ?? 'default.png')) }}" alt="プロフィール画像">
        <p class="name">{{ $user->username }}</p>
        <a class="edit-button" href="{{ route('profile.edit') }}">プロフィールを編集</a>
    </div>
    <div class="tab-container">
        <div class="tab-header">
            <button class="tab active" data-tab="recommend">出品した商品</button>
            <button class="tab" data-tab="mylist">購入した商品</button>
        </div>

        <div class="tab-content active" id="recommend">
            <div class="product-list">
                @foreach($soldItems as $item)

                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ asset('storage/images/' . $item->image_path) }}" alt="{{ $item->name }}" class="product-image">
                        @if ($item->is_sold === 1)
                        <div class="sold-label">SOLD</div>
                        @endif
                    </div>
                    <div class="product-name">{{ $item->name }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="tab-content" id="mylist">
            <div class="product-list">
                @foreach($boughtOrders as $order)
                @if($order->item)

                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ asset('storage/images/' . $order->item->image_path) }}" alt="{{ $order->item->name }}" class="product-image">
                    </div>
                    <div class="product-name">{{ $order->item->name }}</div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    <script>
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // タブのactive切り替え
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // コンテンツ切り替え
                contents.forEach(content => {
                    content.classList.remove('active');
                });
                const selected = tab.getAttribute('data-tab');
                document.getElementById(selected).classList.add('active');
            });
        });
    </script>

</body>

</html>