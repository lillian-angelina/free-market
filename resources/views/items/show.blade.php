@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        @if ($item->image_path)
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="w-full h-64 object-cover">
        @else
            <div class="w-full h-64 bg-gray-200 flex items-center justify-center text-gray-500">
                No Image
            </div>
        @endif

        <div class="p-6">
            <h1 class="text-2xl font-bold mb-2">{{ $item->name }}</h1>
            <p class="text-gray-600 text-lg mb-4">￥{{ number_format($item->price) }}</p>
            <p class="text-gray-800 mb-4">{{ $item->description }}</p>
            <p class="text-sm text-gray-500 mb-6">出品者: {{ $item->user->name ?? '不明' }}</p>

            <a href="{{ url('/purchase/' . $item->id) }}" class="inline-block bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                購入する
            </a>
        </div>
    </div>
</div>
@endsection
