@extends('layouts.app')

@section('title')
    <title>プロフィール画面</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage-index.css') }}">
@endsection

@section('content')
    <div class="profile">
        <div class="profile-header">
            <div class="profile-edit-group1">
                <p class="product_unknown">
                    @if (auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="プロフィール画像" class="user-icon">
                    @else
                        <img src="{{ asset('images/default-user.png') }}" alt="" class="user-icon">
                    @endif
                    <span class="user-name">{{ auth()->user()->name ?? 'ユーザー名' }}</span>
                </p>
            </div>
            <div class="profile-edit-group2">
                <a href="{{ route('mypage.edit') }}" class="profile-edit-button">
                    プロフィールを編集
                </a>
            </div>
        </div>

        <div class="toppage-list">
            <ul class="toppage-list_category">
                <li class="toppage-list_sell"><a href="{{ url('/mypage?page=sell') }}" class="toppage-sell-list">出品した商品</a>
                </li>
                <li class="toppage-list_buy"><a href="{{ url('/mypage?page=buy') }}" class="toppage-buy-list">購入した商品</a>
                </li>
            </ul>
            <div class="toppage-list_items">
                @forelse ($items as $item)
                    <a class="card-items" href="{{ url('/item/' . $item->id) }}">
                        <div class="card">
                            @if ($item->image_path)
                                <img class="card-image" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                            @else
                                <div class="card-image">商品画像</div>
                            @endif

                            <div class="card-body">
                                <p class="card-title">{{ $item->name }}</p>

                                @if ($item->isSold())
                                    <span class="text-red-600 font-bold">Sold</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <p>マイリストに商品がありません。</p>
                @endforelse
            </div>
@endsection