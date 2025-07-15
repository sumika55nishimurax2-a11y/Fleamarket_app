<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
</head>

<body>
    <header class="toppage-header">
        <a href="/">
            <div class="toppage-header-icon"><x-logo class="w-10 h-10 text-blue-500" /></div>
        </a>
        <div class="toppage-header-search"><input type="text" class="input-text" placeholder="なにをお探しですか？"></div>
        <div class="toppage-header-nav">
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                @csrf
            </form>
            <a href="#" class="toppage-header-logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログアウト
            </a>
            <a class="toppage-header-mypage" href="{{ route('mypage.show') }}">マイページ</a>
            <a class="toppage-header-cart" href="{{ route('item.create') }}">出品</a>
        </div>
    </header>
    <form class="purchase-form" action="{{ route('purchase.store', ['item' => $item->id]) }}" method="POST">
        @csrf
        <div class="purchase-container">
            <div class="purchase-item">
                <img class="image" src="{{ asset('storage/images/' . $item->image_path) }}" alt="商品画像">
                <div class="item-details">
                    <p>{{ $item->name }}<br />¥{{ number_format($item->price) }}</p>
                </div>
            </div>
            <div class="purchase-details">
                <p class="title">支払い方法</p>
                <select class="payment-method-label" id="payment_method" name="payment_method" onchange="updatePaymentMethod()">
                    <option value="" disabled selected>選択してください</option>
                    @foreach ($paymentMethods as $method)
                    <option value="{{ $method->name }}">{{ $method->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="purchase-address">
                <div class="address-header">
                    <p class="title">配送先</p>
                    <a class="address-link" href="{{ route('purchase.address.edit', ['item' => $item->id]) }}">変更する</a>
                </div>
                <div class="address-details">
                    <p>〒{{ $user->postal_code }}<br />{{ $user->address }} {{ $user->building }}</p>
                </div>
            </div>
        </div>
        <div class="purchase-confirmation">
            <div class="price-reflection">
                <div>
                    <p class="purchase-confirmation-text">商品代金</p>
                </div>
                <div>
                    <p class="purchase-confirmation-text">¥{{ number_format($item->price) }}</p>
                </div>
            </div>
            <div class="payment-method-reflection">
                <p class="purchase-confirmation-text">支払い方法</p>
                <p class="purchase-confirmation-text" id="selected-payment-method">選択してください</p>
            </div>
            <button class=" purchase-button" type="submit">購入する</button>
        </div>
    </form>
    <script>
        function updatePaymentMethod() {
            const selectedValue = document.getElementById('payment_method').value;
            document.getElementById('selected-payment-method').textContent = selectedValue;
        }
    </script>
</body>

</html>