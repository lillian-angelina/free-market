@extends('layouts.app')

@section('title')
    <title>送付先住所の変更</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase-address.css') }}">
@endsection

@section('content')
    <div class="container">
        <p class="address-title">住所の変更</p>

        <form action="{{ route('shipping.update', ['item_id' => $item->id]) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="postal_code">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code" class="form-control"
                    value="{{ old('postal_code', $address->postal_code ?? '') }}">
                @error('postal_code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="prefecture">住所</label>
                <input type="text" id="prefecture" name="prefecture" class="form-control"
                    value="{{ old('prefecture', $address->prefecture ?? '') }}">
                @error('prefecture')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="building">建物名</label>
                <input type="text" id="building" name="building" class="form-control"
                    value="{{ old('building', $address->building ?? '') }}">
                @error('building')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">
            <button type="submit" class="btn btn-primary">更新する</button>
        </form>
    </div>
@endsection