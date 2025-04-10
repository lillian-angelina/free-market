@extends('layouts.app')

@section('content')
    <h1>送付先住所の変更</h1>
    <form method="POST" action="{{ route('purchase.address.update', $item->id) }}">
        @csrf
        <!-- 住所フォーム -->
    </form>
@endsection
