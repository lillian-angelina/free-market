@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-6">商品一覧</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse ($items as $item)
            <div class="card">
                @if ($item->image_path)
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif

                <div class="card-body">
                    <h2 class="card-title">{{ $item->name }}</h2>
                    <p class="card-price">￥{{ number_format($item->price) }}</p>
                    <p class="card-description">{{ Str::limit($item->description, 100) }}</p>

                    <a href="{{ url('/item/' . $item->id) }}" class="card-button">
                        詳細を見る
                    </a>
                </div>
            </div>
        @empty
            <p>商品が見つかりませんでした。</p>
        @endforelse
    </div>
</div>
@endsection
