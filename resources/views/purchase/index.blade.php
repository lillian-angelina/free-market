@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6">商品購入</h2>

    {{-- 商品情報 --}}
    <div class="flex gap-6 mb-6">
        <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-48 h-48 object-cover rounded">
        <div>
            <h3 class="text-xl font-semibold">{{ $item->name }}</h3>
            <p class="text-lg mt-2">価格: ¥{{ number_format($item->price) }}</p>
            <p class="text-sm text-gray-600 mt-1">現在の送付先住所: {{ $shippingAddress }}</p>
            <a href="{{ route('shipping.edit', ['item_id' => $item->id]) }}" class="text-blue-500 underline text-sm">送付先住所を変更する</a>
        </div>
    </div>

    {{-- 支払い方法選択 --}}
    <div class="mb-6">
        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">支払い方法</label>
        <select id="payment_method" name="payment_method" class="border rounded p-2 w-full" onchange="updatePaymentMethod()">
            <option value="convenience">コンビニ支払い</option>
            <option value="card">カード支払い</option>
        </select>
    </div>

    {{-- 小計確認 --}}
    <div class="mb-6">
        <h4 class="text-lg font-semibold">小計</h4>
        <p id="subtotal" class="text-xl mt-2">¥{{ number_format($item->price) }}</p>
        <p id="payment_note" class="text-sm text-gray-500 mt-1">支払い方法: コンビニ支払い</p>
    </div>

    {{-- 購入ボタン --}}
    <form id="purchase-form" action="{{ route('purchase.store', ['item_id' => $item->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="payment_method" id="payment_method_input" value="convenience">
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            購入する
        </button>
    </form>
</div>

<script>
function updatePaymentMethod() {
    const selected = document.getElementById('payment_method').value;
    const methodInput = document.getElementById('payment_method_input');
    const note = document.getElementById('payment_note');

    methodInput.value = selected;
    if (selected === 'card') {
        note.textContent = '支払い方法: カード支払い';
        // Stripe支払い画面へ誘導などの処理（要バックエンド対応）
    } else {
        note.textContent = '支払い方法: コンビニ支払い';
    }
}
</script>
@endsection
