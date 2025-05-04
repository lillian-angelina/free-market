<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Address;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    /**
     * 送付先編集画面の表示
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        // すでにshipping_addressesがある場合はそれを使う
        $address = Address::where('user_id', $user->id)
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
    public function update(AddressRequest $request, $item_id)
    {
        $user = auth()->user();

        Address::updateOrCreate(
            ['user_id' => $user->id, 'item_id' => $item_id],
            [
                'postal_code' => $request->input('postal_code'),
                'prefecture' => $request->input('prefecture'),
                'building' => $request->input('building'),
            ]
        );

        $paymentMethod = $request->input('payment_method') ?? $request->query('payment_method');

        return redirect()->route('purchase.index', [
            'item_id' => $item_id,
            'payment_method' => $paymentMethod,
        ]);
    }
}
