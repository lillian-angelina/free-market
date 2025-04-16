@extends('layouts.guest')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items-index.css') }}">
@endsection

@section('content')
    <div class="toppage-list">
        <ul class="toppage-list_category">
            <li class="toppage-list_recommend">おすすめ</li>
            <li class="toppage-list_mylist"><a href="{{ url('/guest/?page=mylist') }}" class="toppage-mylist">マイリスト</a>
            </li>
        </ul>
        <div class="toppage-list_items">
            @forelse ($items as $item)
                <div class="card">
                    <a href="{{ url('/item/' . $item->id) }}">
                        @if ($item->image_path)
                            <img class="card-image" src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                        @else
                            <div class="card-image">商品画像</div>
                        @endif
                    </a>
                    <div class="card-body">
                        <a href="{{ url('/item/' . $item->id) }}">
                            <p class="card-title">{{ $item->name }}</p>
                        </a>
                        @auth
                            @if ($item->isSold())
                                <span class="item-sold">Sold</span>
                            @endif
                        @endauth
                    </div>
                </div>
            @empty
                <p>マイリストに商品がありません。</p>
            @endforelse
        </div>
@endsection