@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/items-index.css') }}">
@endsection

@section('content')
    <div class="toppage-list">
        <ul class="toppage-list_category">
            <li class="toppage-list_recommend">おすすめ</li>
            <li class="toppage-list_mylist"><a href="{{ url('/?page=mylist') }}" class="toppage-mylist">マイリスト</a></li>
        </ul>
        <div class="toppage-list_items">
            @forelse ($items as $item)
                <a href="{{ url('/item/' . $item->id) }}">
                    <div class="card">
                        @if ($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
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