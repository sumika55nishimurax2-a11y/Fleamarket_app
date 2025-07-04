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
        <div class="toppage-header-icon"><x-logo class="w-10 h-10 text-blue-500" /></div>
        <div class="toppage-header-search"><input type="text" class="input-text" placeholder="なにをお探しですか？"></div>
        <div class="toppage-header-nav">
            <a class="toppage-header-login" href="">ログアウト</a>
            <a class="toppage-header-mypage" href="">マイページ</a>
            <a class="toppage-header-cart" href="">出品</a>
        </div>
    </header>
    <form class="purchase-form" action="" method="post">
        @csrf
        <div class="purchase-container">
            <div class="purchase-item">
                <img class="image" src="" alt="商品画像">
                <div class="item-details">
                    <p>商品名<br />¥00,000</p>
                </div>
            </div>
            <div class="purchase-details">
                <p class="title">支払い方法</p>
                <label for="payment_method">
                    <select class="payment-method-label" id="payment_method" name="payment_method">
                        <option value="" disabled selected>選択してください</option>
                        <option value="credit_card">カード払い</option>
                        <option value="convenience_store">コンビニ払い</option>
                    </select></label>
            </div>
            <div class="purchase-address">
                <div class="address-header">
                    <p class="title">配送先</p>
                    <a class="address-link" href="">変更する</a>
                </div>
                <div class="address-details">
                    <p>〒XXX-YYYY<br />ここに住所と建物が入ります</p>
                </div>
            </div>
        </div>
        <div class="purchase-confirmation">
            <div class="price-reflection">
                <div>
                    <p class="purchase-confirmation-text">商品代金</p>
                </div>
                <div>
                    <p class="purchase-confirmation-text">¥00,000</p>
                </div>
            </div>
            <div class="payment-method-reflection">
                <p class="purchase-confirmation-text">支払い方法</p>
                <p class="purchase-confirmation-text">コンビニ払い</p>
            </div>
            <button class=" purchase-button" type="submit">購入する</button>
        </div>
    </form>
</body>

</html>