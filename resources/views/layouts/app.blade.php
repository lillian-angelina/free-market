<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>実践学習ターム 模擬案件初級_フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/layouts-common.css') }}">
    @vite('resources/css/app.css') <!-- Vite CSS -->
    @yield('css')
</head>

<body>
@yield('css')
    <header class="toppage-header">
        <div class="toppage-header-logo">
            <a href="{{ url('/') }}" class="toppage-header-icon"><img src="{{ asset('images/logo.svg') }}"
                    alt="Logo"></a>
        </div>
        <div class="toppage-header-search">
            <form action="{{ url('/search') }}" method="GET" class="toppage-header-search-form">
                @csrf
                <input type="text" name="query" placeholder="なにをお探しですか？" class="toppage-header-search-input" oninput="this.form.submit()">
            </form>
        </div>
        <nav class="toppage-header-nav">
            <ul class="toppage-header-nav_ul">
                <li>
                    <form class="form" action="{{ url('/search') }}" method="GET">
                        @csrf
                    </form>
                    <li class="toppage-header-nav_login"><a href="{{ route('login') }}">ログイン</a></li>
                    <li class="toppage-header-nav_mypage"><a href="{{ url('/mypage') }}">マイページ</a></li>
                    <li class="toppage-header-nav_listing"><a href="{{ url('/items/create') }}">出品</a></li>
            </ul>
        </nav>
    </header>

    <main class="py-8">
        @yield('content')
    </main>

    <footer>

    </footer>
</body>

</html>