@extends('layouts.guest')

@section('title')
    <title>{{ $item->name ?? '商品詳細' }}</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items-show.css') }}">
@endsection

@section('content')
    <div class="product">
        <div class="product-detail">
            <div class="product-detail-card">
                @if ($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="product-image">
                @else
                    <div class="product-image">
                        商品画像
                    </div>
                @endif
            </div>

            <div class="product-description-area">
                <div class="product-title">
                    <h3 class="product_name">{{ $item->name ?? '商品名がここに入る' }}</h3>
                    <p class="product_brand-name">{{ $item->brand->name ?? 'ブランド不明' }}</p>
                    <p class="product_price">￥ <span class="price">{{ number_format($item->price) }}</span> (税込)</p>
                    <p class="product-actions">
                        {{-- いいねボタン --}}
                        @auth
                            <form action="{{ route('items.like', ['item' => $item->id]) }}" method="POST">
                                @csrf
                                <div class="count-content">
                                    <button type="submit" class="like-button" style="font-size: 20px;">
                                        @if ($item->isLikedBy(Auth::user()))
                                            <label class="likes">⭐</label><br><span
                                                class="count-likes">{{ $item->likes->count() }}</span>

                                        @else
                                            <label class="likes">☆</label><br><span
                                                class="count-likes">{{ $item->likes->count() }}</span>

                                        @endif
                                    </button>
                                </div>
                                <div class="count-content">
                                    <p class="icon">💭</p><br>
                                    <span class="count-comments">{{ $item->comments->count() }}</span>
                                </div>
                            </form>
                        @else
                            <a href="{{ route('login') }}" style="color: black; font-size: 20px;">☆</a>
                            <span class="icon" style="font-size: 20px;">💭</span>
                            <span class="count-likes">{{ $item->likes->count() }}<span
                                    class="count-comments">{{ $item->comments->count() }}</span>
                            </span>
                        @endauth
                    </p>

                </div>
                <div class="purchase-area">
                    <a class="purchase-button" href="{{ url('/purchase/' . $item->id) }}">購入手続きへ</a>
                </div>
                <div class="product-description">
                    <p class="product_description-item1">商品説明</p>
                    <p class="product_description-item2">カラー : <span class="color-item">{{ $item->color ?? 'グレー'}}</span>
                    </p>{{-- カラー --}}
                    <p class="product_description-item3"><span class="condition-item">{{ $item->condition ?? '新品'}}</span>
                    </p> {{-- 商品の状態 --}}
                    <p class="product_description-item4"><span
                            class="description-item">{{ $item->description ?? '商品の状態は良好です。傷もありません。'}}</span></p> {{-- 商品説明
                    --}}
                    <p class="product_description-item5"><span
                            class="shipping">{{ $item->shipping_method ?? '購入後、即発送いたします。'}}</span></p> {{-- 配送の方法 --}}
                </div>
                <div class="product-info">
                    <p class="product_description-item1">商品情報</p>
                    <div class="product-category">
                        <p class="product-category_item6">カテゴリー
                            @foreach($item->categories as $category)
                                <span class="category">{{ $category->name }}</span>
                            @endforeach
                        </p>
                    </div>
                    <div class="product-condition">
                        <p class="product_description-item">商品の状態<span
                                class="condition">{{ $item->condition ?? '良好' }}</span></p> {{-- 商品の状態 --}}
                    </div>
                </div>
                <div class="product-comment">
                    <p class="product-comment_item">コメント（{{ $item->comments->count() }}）</p>
                    <p class="product_unknown"><span class="user-name">{{ $item->user->name ?? 'admin' }}</span></p>
                    <div class="comment-list">
                        @foreach ($item->comments as $comment)
                            <div class="comment-text">
                                <p>{{ $comment->user->name }}：{{ $comment->body ?? 'こちらにコメントが入ります。' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <form action="{{ url('/items/' . $item->id . '/comments') }}" method="POST">
                    @csrf
                    <div class="comment-input">
                        <p class="item-comment">商品へのコメント</p>
                        <textarea name="body" class="comment-form"></textarea>
                        <div class="comment-button">
                            <button type="submit" class="comment-submit">コメントを送信する</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection