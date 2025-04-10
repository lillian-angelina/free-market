@extends('layouts.app')

@section('content')
    <h1>ログイン</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- 入力フィールド -->
    </form>
@endsection
