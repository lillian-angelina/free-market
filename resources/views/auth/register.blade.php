@extends('layouts.app')

@section('content')
    <h1>会員登録</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- 入力フィールド -->
    </form>
@endsection
