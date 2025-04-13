<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ShippingAddress;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    /**
     * 送付先編集画面の表示
     */
    public function edit($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        // すでにshipping_addressesがある場合はそれを使う
        $address = ShippingAddress::where('user_id', $user->id)
                                  ->where('item_id', $item_id)
                                  ->first();

        // なければデフォルト住所（addressesテーブル）を初期値として使う
        if (!$address) {
            $default = Address::where('user_id', $user->id)->first();
            $address = $default;
        }

        return view('purchase.address', compact('item', 'address'));
    }

    /**
     * 送付先住所の保存
     */
    public function update(Request $request, $item_id)
    {
        $user = Auth::user();

        // バリデーション
        $validated = $request->validate([
            'postal_code' => 'required|string|max:10',
            'prefecture'  => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'street'      => 'required|string|max:255',
            'building'    => 'nullable|string|max:255',
        ]);

        // 保存または更新
        $shipping = ShippingAddress::updateOrCreate(
            ['user_id' => $user->id, 'item_id' => $item_id],
            $validated
        );

        return redirect()->route('purchase.index', ['item_id' => $item_id])
                         ->with('success', '送付先住所を更新しました');
    }
}
