@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item-show.css') }}">
@endsection

@section('content')
    <div class="product">
        <div class="product-detail">
            <div class="product-detail-card">
                @if ($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"
                        class="w-full h-64 object-cover">
                @else
                    <div class="prodct-image">
                        商品画像
                    </div>
                @endif
            </div>

            <div class="product-description-area">
                <div class="product-title">
                    <h3 class="product_name">{{ $item->name }}</h3>
                    <p class="product_brand-name">ブランド名</p>
                    <p class="product_price">￥{{ number_format($item->price) }}</p>
                </div>
                <div class="purchase-area">
                    <a class="purchase-button" href="{{ url('/purchase/' . $item->id) }}">購入手続きへ</a>
                </div>
                <div class="product-description">
                    <p class="product_description-item">商品説明</p>
                    <p class="product_description-item">カラー: {{ $item->color }}</p>{{-- カラー --}}
                    <p class="product_description-item">{{ $item->description }}</p> {{-- 商品説明 --}}
                    <p class="product_description-item">{{ $item->condition }}</p> {{-- 商品の状態 --}}
                    <p class="product_description-item">{{ $item->shipping_method }}</p> {{-- 配送の方法 --}}
                </div>
                <div class="product-info">
                    <p class="product_description-item">商品情報</p>
                    <div class="product-category">
                        <p class="product-category_item">{{ $item->category->name ?? '不明' }}</p> {{-- カテゴリー --}}
                    </div>
                    <div class="product-condition">
                        <p class="product_description-item">{{ $item->condition }}</p> {{-- 商品の状態 --}}
                    </div>
                </div>
                <div class="product-comment">
                    <p class="product-comment_item">コメント</p>
                    <p class="product_unknown">{{ $item->user->name ?? '不明' }}</p>
                    <div class="comment-list">
                        <p class="product_comment-list">コメント内容</p>
                        <input type="text" class="comment-text" placeholder="こちらにコメントが入ります。">
                    </div>
                </div>
                <div class="comment-input">
                    <p class="item-comment">商品へのコメント</p>
                    <textarea name="text" id="" class="comment-form"></textarea>
                    <div class="comment-button">
                        <button type="submit" class="comment-submit">コメントを送信する</button>
                    </div>
                </div>
            </div>
        </div>
@endsection