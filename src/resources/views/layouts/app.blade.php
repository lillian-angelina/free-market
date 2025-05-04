<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')
    <title>実践学習ターム 模擬案件初級_フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/layouts-common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @yield('css')
</head>

<body>
    @yield('css')
    <header class="toppage-header">
        <div class="toppage-header-logo">
            <a href="{{ url('/') }}" class="toppage-header-icon">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo">
            </a>
        </div>

        {{-- 検索フォーム --}}
        <div class="toppage-header-search">
            <form action="{{ url('/search') }}" method="GET" class="toppage-header-search-form">
                <input type="text" name="query" placeholder="なにをお探しですか？" value="{{ request('query') }}"
                    class="toppage-header-search-input">
            </form>
        </div>

        {{-- ナビゲーション --}}
        <nav class="toppage-header-nav">
            <ul class="toppage-header-nav_ul">
                {{-- ログアウト（POST送信） --}}
                @auth
                    <li class="toppage-header-nav_logout">
                        <form class="form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-link">ログアウト</button>
                        </form>
                    </li>
                @else
                    <li class="toppage-header-nav_login">
                        <a href="{{ route('login') }}" class="login-link">ログイン</a>
                    </li>
                @endauth

                {{-- マイページ --}}
                <li class="toppage-header-nav_mypage">
                    <a href="{{ url('/mypage') }}">マイページ</a>
                </li>

                {{-- 出品ページ --}}
                <li class="toppage-header-nav_listing">
                    <a href="{{ url('/sell') }}" style="color: #000000;">出品</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
        @yield('css')
    </main>

    <footer>

    </footer>

    @yield('js')
</body>

</html>