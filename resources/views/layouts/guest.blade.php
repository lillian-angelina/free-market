<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')
    <title>実践学習ターム 模擬案件初級_フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/layouts-common.css') }}">
    @yield('css')
</head>

<body>
    @yield('css')
    <header class="toppage-header">
        <div class="toppage-header-logo">
            <a href="{{ url('/guest') }}" class="toppage-header-icon"><img src="{{ asset('images/logo.svg') }}"
                    alt="Logo"></a>
        </div>
        <div class="toppage-header-search">
            <form action="{{ url('/search') }}" method="GET" class="toppage-header-search-form">
                @csrf
                <input type="text" name="query" placeholder="なにをお探しですか？" class="toppage-header-search-input"
                    oninput="this.form.submit()">
            </form>
        </div>
        <nav class="toppage-header-nav">
            <ul class="toppage-header-nav_ul">
                <li>
                    <form class="form" action="{{ url('/search') }}" method="GET">
                        @csrf
                    </form>
                </li>
                <li class="toppage-header-nav_login"><a href="{{ route('login') }}">ログイン</a></li>
                <li class="toppage-header-nav_mypage"><a href="{{ url('/mypage') }}">マイページ</a></li>
                <li class="toppage-header-nav_listing"><a href="{{ url('/sell') }}"style="color: #000000;">出品</a></li>
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