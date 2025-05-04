<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Address;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    public function index(\Illuminate\Http\Request $request, $item_id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', '購入手続きにはログインが必要です。');
        }

        $item = Item::findOrFail($item_id);

        $shippingAddress = Address::where('user_id', $user->id)
            ->where('item_id', $item_id)
            ->first();

        $selected = $request->query('payment_method', '選択してください');

        return view('purchase.index', compact('item', 'shippingAddress', 'selected'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $user = Auth::user();
        $item = $this->getItemIfAvailable($item_id);
        $shipping = $this->getShippingAddress($user->id, $item_id);
        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod === 'card') {
            return $this->processStripePayment($item);
        }

        if ($paymentMethod === 'convenience') {
            return $this->processConveniencePayment($user, $item, $shipping);
        }

        return back()->withErrors(['payment_method' => '無効な支払い方法です。']);
    }

    private function getItemIfAvailable($item_id)
    {
        $item = Item::findOrFail($item_id);
        if ($item->sold_flg) {
            abort(400, 'この商品はすでに売り切れました。');
        }
        return $item;
    }

    private function getShippingAddress($user_id, $item_id)
    {
        $address = Address::where('user_id', $user_id)->where('item_id', $item_id)->first();
        if (!$address) {
            abort(400, '配送先が未設定です。');
        }
        return $address;
    }

    private function processStripePayment($item)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'jpy',
                            'product_data' => ['name' => $item->name],
                            'unit_amount' => $item->price,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('purchase.success', ['item_id' => $item->id]),
                'cancel_url' => route('purchase.index', ['item_id' => $item->id]),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            Log::error('Stripeエラー: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Stripe決済に失敗しました。']);
        }
    }

    private function processConveniencePayment($user, $item, $shipping)
    {
        $item->sold_flg = true;
        $item->save();

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'convenience',
            'shipping_address' => $this->formatShippingAddress($shipping),
        ]);

        return redirect()->route('mypage.purchased_items')->with('success', '購入が完了しました（コンビニ支払い）');
    }

    private function formatShippingAddress($address)
    {
        return "〒{$address->postal_code} {$address->prefecture} {$address->city} {$address->street} {$address->building}";
    }


    public function success($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        if (!$item->sold_flg) {
            $item->sold_flg = true;
            $item->save();

            $shipping = Address::where('user_id', $user->id)
                ->where('item_id', $item_id)
                ->first();

            Purchase::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => 'card',
                'shipping_address' => $shipping
                    ? "〒{$shipping->postal_code} {$shipping->prefecture} {$shipping->city} {$shipping->street} {$shipping->building}"
                    : null,
            ]);
        }

        return redirect()->route('mypage.purchased_items')->with('success', 'カードでの購入が完了しました。');
    }
}