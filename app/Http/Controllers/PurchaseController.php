<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\ShippingAddress;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\StripeClient;


class PurchaseController extends Controller
{

    public function index($item_id)
    {
        $user = Auth::user();

        // 未ログインならログインページへ
        if (!$user) {
            return redirect()->route('login')->with('error', '購入手続きにはログインが必要です。');
        }

        $item = Item::findOrFail($item_id);

        // すでに購入済みかチェック
        $alreadyPurchased = Purchase::where('user_id', $user->id)
            ->where('item_id', $item_id)
            ->exists();

        $shippingAddress = $user->shipping_address ?? '未設定';

        if ($alreadyPurchased) {
            return redirect()->route('profile.purchased_items')
                ->with('error', 'この商品はすでに購入済みです。');
        }

        return view('purchase.index', compact('item', 'shippingAddress'));
    }

    public function store(Request $request, $item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        // 売り切れチェック
        if ($item->sold) {
            return back()->withErrors(['error' => 'この商品はすでに売り切れました。']);
        }

        $paymentMethod = $request->input('payment_method');

        // 商品のステータスを更新
        $item->sold = true;
        $item->save();

        // 購入記録を保存
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => $paymentMethod,
        ]);

        // Stripe決済処理（カード支払い時）
        if ($paymentMethod === 'card') {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'jpy',
                            'product_data' => [
                                'name' => $item->name,
                            ],
                            'unit_amount' => $item->price,
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('profile.purchased_items') . '?success=true',
                'cancel_url' => route('purchase.index', ['item_id' => $item->id]),
            ]);

            return redirect($session->url);
        }

        // コンビニ支払いの場合は即完了
        return redirect()->route('profile.purchased_items')->with('success', '購入が完了しました（コンビニ支払い）');
    }
}
