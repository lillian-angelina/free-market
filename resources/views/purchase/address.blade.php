@extends('layouts.app')

@section('title', '送付先住所の変更')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">送付先住所の変更</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('shipping.update', ['item_id' => $item->id]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="postal_code" class="form-label">郵便番号</label>
            <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $address->postal_code ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="prefecture" class="form-label">都道府県</label>
            <input type="text" name="prefecture" class="form-control" value="{{ old('prefecture', $address->prefecture ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">市区町村</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $address->city ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="street" class="form-label">番地</label>
            <input type="text" name="street" class="form-control" value="{{ old('street', $address->street ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="building" class="form-label">建物名（任意）</label>
            <input type="text" name="building" class="form-control" value="{{ old('building', $address->building ?? '') }}">
        </div>

        <button type="submit" class="btn btn-primary">保存する</button>
        <a href="{{ route('purchase.index', ['item_id' => $item->id]) }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection
