@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mylist.css') }}">
@endsection

@section('content')
    <div class="toppage-list">
        <div class="toppage-list_items">
            @forelse ($items as $item)
                <div class="card">
                    @if ($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}"><a
                            href="{{ url('/item/' . $item->id) }}" class="card-button"></a>
                    @else
                        <div class="card-image">
                            商品画像
                        </div>
                    @endif

                    <div class="card-body">
                        <p class="card-title">{{ $item->name }}</p>
                        <p class="card-price">￥{{ number_format($item->price) }}</p>
                        <p class="card-description">{{ Str::limit($item->description, 100) }}</p>

                        @if ($item->isSold())
                            <span class="text-red-600 font-bold">Sold</span>
                        @else
                            <a href="{{ url('/item/' . $item->id) }}" class="card-button"></a>
                        @endif
                    </div>
                </div>
            @empty
                <p>マイリストに商品がありません。</p>
            @endforelse
        </div>
@endsection