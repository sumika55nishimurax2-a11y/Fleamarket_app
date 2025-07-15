<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
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
    <form class="address-form" action="{{ route('purchase.address.update', ['item' => $item->id]) }}" method="post" novalidate>
        @csrf
        <p class="title">住所の変更</p>
        <div class="address-edit">
            <label>郵便番号</label>
            <input class="address-input" type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            <label>住所</label>
            <input class="address-input" type="text" name="address" value="{{ old('address', $user->address) }}">
            <label>建物名</label>
            <input class="address-input" type="text" name="building" value="{{ old('building', $user->building) }}">
            <button class="address-button" type="submit">更新する</button>
        </div>
    </form>

</body>

</html>