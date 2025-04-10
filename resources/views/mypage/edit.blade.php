@extends('layouts.app')

@section('content')
    <h1>プロフィール編集</h1>
    <form method="POST" action="{{ route('mypage.profile.update') }}">
        @csrf
        <!-- プロフィール編集フォーム -->
    </form>
@endsection
