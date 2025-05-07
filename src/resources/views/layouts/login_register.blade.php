<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')
    <title>実践学習ターム 模擬案件初級_フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/login_register.css') }}">
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