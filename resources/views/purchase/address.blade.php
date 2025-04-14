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

            <div class="form-group">
                <label for="prefecture" class="form-label">住所</label>
                <input type="text" id="prefecture" name="prefecture" class="form-control"
                    value="{{ old('prefecture', $address->prefecture ?? '') }}">
            </div>

            <div class="form-group">
                <label for="building" class="form-label">建物名</label>
                <input type="text" id="building" name="building" class="form-control"
                    value="{{ old('building', $address->building ?? '') }}">
            </div>

            <button type="submit" class="btn btn-primary">更新する</button>
        </form>
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
    </div>
@endsection