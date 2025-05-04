{{-- resources/views/auth/verify-email.blade.php --}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('title')
    <title>メール認証</title>
@endsection

@section('content')
    <div class="container">
        <div class="container-group">
            <div class="mail-certification">
                <p>登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</p>
            </div>

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="content">
                <div class="certification">
                    <p><a href="{{ route('verification.notice') }}">認証はこちらから</a></p>
                </div>
            </div>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">確認メールを再送する</button>
            </form>
        </div>
    </div>
@endsection