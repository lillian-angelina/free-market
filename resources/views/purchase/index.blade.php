@extends('layouts.app')

@section('content')
    <h1>{{ $item->name }} を購入</h1>
    <form method="POST" action="{{ route('purchase.confirm', $item->id) }}">
        @csrf
        <!-- 購入情報フォーム -->
    </form>
@endsection
