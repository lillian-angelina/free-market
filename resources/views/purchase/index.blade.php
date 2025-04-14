@extends('layouts.app')

@section('title')
    <title>商品購入</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase-index.css') }}">
@endsection

@section('content')
    <div class="container">

        {{-- 商品情報 --}}
        <div class="item-content">
            <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="item-image">
            <div class="item-details">
                <div class="item-details_content">
                    <h3 class="item-name">{{ $item->name }}</h3>
                    <p class="item-price_first">¥{{ number_format($item->price) }}</p>
                </div>
            </div>
            <div class="item-details_content2">
                <div class="item-details_actions-box1">
                    <p class="item-money">商品代金</p>
                    <p class="payment-method_p">支払い方法</p>
                </div>
                <div class="item-details_actions-box2">
                    <p class="item-price_second">¥{{ number_format($item->price) }}</p>
                    <p class="selected-method" id="selected-method">コンビニ支払い</p>
                </div>
            </div>
        </div>

        <div class="line"></div>

        {{-- 購入ボタン --}}
        <form class="purchase" id="purchase-form" action="{{ route('purchase.store', ['item_id' => $item->id]) }}"
            method="POST">
            @csrf
            <input type="hidden" name="payment_method" id="payment_method_input" value="convenience">
            <button type="submit" class="purchase-button">
                購入する
            </button>
        </form>

        {{-- 支払い方法選択 --}}
        <div class="payment-method">
            <label for="payment_method" class="payment-method_label">支払い方法</label>
            <select id="payment_method" name="payment_method" class="payment-method_select"
                onchange="updatePaymentMethod()">
                <option value="convenience">コンビニ支払い</option>
                <option value="card">カード支払い</option>
            </select>
        </div>

        <div class="line"></div>

        {{-- 配送先情報 --}}
        <div class="shipping-address-content">
            <div class="shipping-address_header">
                <h4 class="shipping-address">配送先</h4>
                <a href="{{ route('shipping.edit', ['item_id' => $item->id]) }}" class="shipping-address_change">変更する</a>
            </div>
            <p class="shipping-address_details">
                {{ $shippingAddress ?? '未設定' }}
            </p>
        </div>
        <div class="line"></div>
    </div>



    <script>
        function updatePaymentMethod() {
            const selected = document.getElementById('payment_method').value;
            const methodInput = document.getElementById('payment_method_input');
            const selectedMethodDisplay = document.getElementById('selected-method');

            methodInput.value = selected;
            selectedMethodDisplay.textContent = selected === 'card' ? 'カード支払い' : 'コンビニ支払い';
        }
    </script>
@endsection