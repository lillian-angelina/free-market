@extends('layouts.app')

@section('title')
    <title>商品購入</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase-index.css') }}">
@endsection

@section('content')
    @php
        $selected = old('payment_method') ?? request()->query('payment_method') ?? '選択してください';
    @endphp
    <div class="container">

        {{-- 商品情報 --}}
        <div class="item-content">
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
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
                    <p class="selected-method" id="selected-method">
                        {{ $selected === 'card' ? 'カード支払い' : ($selected === 'convenience' ? 'コンビニ支払い' : '') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="line"></div>

        {{-- 購入ボタン --}}
        <form class="purchase" id="purchase-form" action="{{ route('purchase.store', ['item_id' => $item->id]) }}"
            method="POST">
            @csrf
            {{-- 支払い方法選択 --}}
            <div class="payment-method">
                <label for="payment_method" class="payment-method_label">支払い方法</label>
                <select id="payment_method" name="payment_method" class="payment-method_select"
                    onchange="updatePaymentMethod()">
                    <option value="選択してください" {{ $selected === '選択してください' ? 'selected' : '' }}>選択してください</option>
                    <option value="convenience" {{ $selected === 'convenience' ? 'selected' : '' }}>コンビニ支払い</option>
                    <option value="card" {{ $selected === 'card' ? 'selected' : '' }}>カード支払い</option>
                </select>
                @error('payment_method')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="purchase-button-item">
                <button type="submit" class="purchase-button">
                    購入する
                </button>
            </div>
        </form>

        <div class="line"></div>

        {{-- 配送先情報 --}}
        <div class="shipping-address-content">
            <div class="shipping-address_header">
                <h4 class="shipping-address">配送先</h4>
                <a id="change-shipping-link" href="#" class="shipping-address_change">
                    変更する
                </a>
            </div>
            <p class="shipping-address_details">
                @if ($shippingAddress)
                    〒{{ $shippingAddress->postal_code }}<br>
                    {{ $shippingAddress->prefecture }}{{ $shippingAddress->shipping_address }}　{{ $shippingAddress->building }}
                @else
                    未設定
                @endif
            </p>
            @if ($errors->has('shipping_address'))
                <div class="text-danger">
                    {{ $errors->first('shipping_address') }}
                </div>
            @endif
        </div>

        <div class="line"></div>

    </div>



    <script>
        function updatePaymentMethod() {
            const selected = document.getElementById('payment_method').value;
            const selectedMethodDisplay = document.getElementById('selected-method');
            const changeLink = document.getElementById('change-shipping-link');

            if (selected === 'card') {
                selectedMethodDisplay.textContent = 'カード支払い';
            } else if (selected === 'convenience') {
                selectedMethodDisplay.textContent = 'コンビニ支払い';
            } else {
                selectedMethodDisplay.textContent = '';
            }

            const baseUrl = "{{ route('shipping.edit', ['item_id' => $item->id]) }}";
            changeLink.href = `${baseUrl}?payment_method=${encodeURIComponent(selected)}`;
        }

        // 初期表示時にも実行
        window.addEventListener('DOMContentLoaded', () => {
            updatePaymentMethod();
            document.getElementById('payment_method').addEventListener('change', updatePaymentMethod);
        });
    </script>
@endsection