<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COACHTECH</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
</head>

<body>

    <header class="toppage-header">
        <div class="toppage-header-icon"><x-logo class="w-10 h-10 text-blue-500" /></div>
    </header>
    <main>
        <div class="checkout-container">
            <h2 class="checkout-text">登録していただいたメールアドレスに認証メールを送付しました。<br />メール認証を完了してください。</h2>

            <form method="GET" action="{{ route('verification.notice') }}">
                <button type="submit" class="auth-button">認証はこちらから</button>
            </form>

            <form method="POST" action="{{ route('verification.send') }}" class="resend-form">
                @csrf
                <button type="submit" class="resend-button">認証メールを再送する</button>
            </form>
        </div>
    </main>

</body>

</html>