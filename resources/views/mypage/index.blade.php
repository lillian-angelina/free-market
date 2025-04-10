@extends('layouts.app')

@section('content')
    <h1>マイページ</h1>

    @if(request()->get('page') === 'buy')
        <h2>購入した商品一覧</h2>
        <!-- 購入商品リスト -->
    @elseif(request()->get('page') === 'sell')
        <h2>出品した商品一覧</h2>
        <!-- 出品商品リスト -->
    @else
        <p>マイプロフィール情報など</p>
    @endif
@endsection
