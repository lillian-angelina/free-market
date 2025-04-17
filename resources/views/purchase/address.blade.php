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
                <label for="postal_code" class="form-label">郵便番号</label>
                <input type="text" id="postal_code" name="postal_code" class="form-control"
                    value="{{ old('postal_code', $address->postal_code ?? '') }}">
            </div>
            <div class="alert alert-danger">
                @if ($errors->has('postal_code'))
                    <div class="alert alert-danger">{{ $errors->first('postal_code') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="address" class="form-label">住所</label>
                <input type="text" id="address" name="prefecture" class="form-control"
                    value="{{ old('prefecture', $address->prefecture ?? '') }}">
            </div>
            <div class="alert alert-danger">
                @if ($errors->has('prefecture'))
                    <div class="alert alert-danger">{{ $errors->first('prefecture') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="building" class="form-label">建物名</label>
                <input type="text" id="building" name="building" class="form-control"
                    value="{{ old('building', $address->building ?? '') }}">
            </div>
            <div class="alert alert-danger">
                @if ($errors->has('building'))
                    <div class="alert alert-danger">{{ $errors->first('building') }}</div>
                @endif
            </div>
            <input type="hidden" name="payment_method" value="{{ request('payment_method') }}">
            <button type="submit" class="btn btn-primary">更新する</button>
        </form>
    </div>
@endsection