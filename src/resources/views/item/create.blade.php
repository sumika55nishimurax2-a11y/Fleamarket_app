<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTEC</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/item_create.css') }}" />
</head>

<body>
    <header class="toppage-header">
        <a href="/">
            <div class="toppage-header-icon"><x-logo class="w-10 h-10 text-blue-500" /></div>
        </a>
        <div class="toppage-header-search"><input type="text" class="input-text" placeholder="なにをお探しですか？"></div>
        <div class="toppage-header-nav">
            <a class="toppage-header-login" href="{{ route('logout') }}">ログアウト</a>
            <a class="toppage-header-mypage" href="{{ route('mypage.show') }}">マイページ</a>
            <a class="toppage-header-cart" href="{{ route('item.create') }}">出品</a>
        </div>
    </header>
    <form class="create-form" action="" method="post" enctype="multipart/form-data">
        @csrf
        <p class="create-title">商品の出品</p>

        <div class="item-create">
            <p class="item-details-subtitle">商品画像</p>
            <div class="image-wrapper">
                <label for="image" class="custom-file-label" id="image-label">
                    <span class="label-text">画像を選択する</span>
                </label>
                <label for="image">
                    <img class="preview-image" src="" alt="プレビュー">
                </label>
                <input class="image-choice" type="file" id="image" name="image">
            </div>
        </div>
        <div class="item-details">
            <p class="item-details-title">商品の詳細</p>
            <p class="item-details-subtitle">カテゴリー</p>
            <div class="category-container">
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="ファッション" hidden>
                    ファッション
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="家電" hidden>
                    家電
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="インテリア" hidden>
                    インテリア
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="レディース" hidden>
                    レディース
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="メンズ" hidden>
                    メンズ
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="コスメ" hidden>
                    コスメ
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="本" hidden>
                    本
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="ゲーム" hidden>
                    ゲーム
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="スポーツ" hidden>
                    スポーツ
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="キッチン" hidden>
                    キッチン
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="ハンドメイド" hidden>
                    ハンドメイド
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="アクセサリー" hidden>
                    アクセサリー
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="おもちゃ" hidden>
                    おもちゃ
                </label>
                <label class="category-button">
                    <input type="checkbox" name="category[]" value="ベビー・キッズ" hidden>
                    ベビー・キッズ
                </label>
            </div>
        </div>
        <div class="item-condition-container">
            <p class="item-details-subtitle">商品の状態</p>
            <label class="item-condition" for="condition">
                <select class="item-condition" id="condition" name="condition" required>
                    <option value="" disabled selected>選択してください</option>
                    <option value="">良好</option>
                    <option value="">目立った傷や汚れなし</option>
                    <option value="">やや傷や汚れあり</option>
                    <option value="">状態が悪い</option>
                </select>
            </label>
        </div>

        <div class="">
            <p class="item-details-title">商品名と説明</p>

            <div>
                <p class="item-details-subtitle">商品名</p>
                <label class="item-name" for=" name">
                    <input class="item-name" type="text" id="name" name="name" value="" required>
                </label>
            </div>

            <div>
                <p class="item-details-subtitle">ブランド名</p>
                <label class="item-brand" for=" brand">
                    <input class="item-brand" type="text" id="brand" name="brand" value=""></label>
            </div>
            <div>
                <p class="item-details-subtitle">商品の説明</p>
                <label class="item-description" for="description">
                    <textarea class="item-description" id=" description" name="description" required></textarea></label>
            </div>
            <div>
                <p class="item-details-subtitle">販売価格</p>
                <label class="item-price" for="price">
                    <input class="item-price" type="text" id="price" name="price" value="¥" required></label>
            </div>

        </div>
        <button class="create-button" type=" submit">出品する</button>
    </form>
    <script>
        document.querySelectorAll('.category-button').forEach(label => {
            const input = label.querySelector('input');

            input.addEventListener('change', () => {
                if (input.checked) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            });
        });

        document.getElementById('image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.querySelector('.preview-image');
            const label = document.querySelector('.custom-file-label');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    label.style.display = 'none'; // 赤枠含む「画像を選択する」非表示
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>