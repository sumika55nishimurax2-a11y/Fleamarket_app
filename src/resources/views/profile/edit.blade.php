<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/edit.css') }}" />
</head>

<body>
    <header class="toppage-header">
        <a href="/">
            <div class="toppage-header-icon"><x-logo class="w-10 h-10 text-blue-500" /></div>
        </a>
        <div class="toppage-header-search"><input type="text" class="input-text" placeholder="なにをお探しですか？"></div>
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
    <form class="edit-content" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf

        <p class="title">プロフィール設定</p>
        <div class="image-container">
            <img class="image-preview" src="{{ asset('storage/' . $user->avatar) }}">
            <label for="image" class="custom-file-label">画像を選択する</label>
            <input class="image-choice" type="file" id="image" name="avatar">
        </div>

        <div class="profile-edit">
            <label for="name">ユーザー名</label>
            <input class="input" type="text" id="username" name="username"
                value="{{ old('username', $user->username) }}" required>

            <label for="postal_code">郵便番号</label>
            <input class="input" type="text" id="postal_code" name="postal_code"
                value="{{ session('first_login') ? '' : old('postal_code', $user->postal_code) }}" required>
            <label for="address">住所</label>
            <input class="input" type="text" id="address" name="address"
                value="{{ session('first_login') ? '' : old('address', $user->address) }}" required>
            <label for="building">建物名</label>
            <input class="input" type="text" id="building" name="building"
                value="{{ session('first_login') ? '' : old('building', $user->building) }}">



            <button class="update-button" type="submit">更新する</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.querySelector('.image-preview');

            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

</body>

</html>