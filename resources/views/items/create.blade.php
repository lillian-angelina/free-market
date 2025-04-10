@extends('layouts.app')

@section('content')
    <h1>商品を出品する</h1>
    <form method="POST" action="{{ route('items.store') }}">
        @csrf
        <!-- 出品フォーム -->
    </form>
@endsection
