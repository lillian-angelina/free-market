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
    <header class="header">
        <div class="header_logo">
            <a href="{{ url('/') }}" class="header_logo--icon">
                <img src="{{ asset('images/logo.svg') }}" alt="Logo">
            </a>
        </div>

        {{-- 検索フォーム --}}
        <div class="header_search">
            <form action="{{ url('/search') }}" method="GET" class="header_search--form">
                <input type="text" name="query" placeholder="なにをお探しですか？" value="{{ request('query') }}"
                    class="header_search--input">
            </form>
        </div>

        {{-- ナビゲーション --}}
        <nav class="header_nav">
            <ul class="header_nav--ul">
                {{-- ログアウト（POST送信） --}}
                @auth
                    <li class="header_nav--logout">
                        <form class="form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="header_form--logout">ログアウト</button>
                        </form>
                    </li>
                @else
                    <li class="header_nav--login">
                        <a href="{{ route('login') }}" class="header_form--login">ログイン</a>
                    </li>
                @endauth

                {{-- マイページ --}}
                <li class="header_nav--mypage">
                    <a href="{{ url('/mypage') }}">マイページ</a>
                </li>

                {{-- 出品ページ --}}
                <li class="header_nav--listing">
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