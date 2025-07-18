<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <header class="toppage-header">
        <div class="toppage-header-icon">
            <x-logo class="w-10 h-10 text-blue-500" />
        </div>
    </header>

    <form class="auth-form" action="{{ route('login') }}" method="POST" novalidate>
        @csrf
        <h1>ログイン</h1>

        <div class="auth-input">
            <p class="auth-input-label">メールアドレス</p>
            <label for="email">
                <input class="auth-input-field" type="email" id="email" name="email" required value="{{ old('email') }}">
            </label>
            @error('email')
            <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-input">
            <p class="auth-input-label">パスワード</p>
            <label for="password">
                <input class="auth-input-field" type="password" id="password" name="password" required>
            </label>
            @error('password')
            <div class="auth-error">{{ $message }}</div>
            @enderror
        </div>

        <button class="auth-button" type="submit">ログイン</button>

        <div>
            <a class="auth-link" href="{{ route('register') }}">会員登録はこちら</a>
        </div>
    </form>
</body>

</html>