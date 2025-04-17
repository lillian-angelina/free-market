<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\ShippingAddress;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Log;


class PurchaseController extends Controller
{

    public function index(Request $request, $item_id)
    {
        $user = Auth::user();

        // 未ログインならログインページへ
        if (!$user) {
            return redirect()->route('login')->with('error', '購入手続きにはログインが必要です。');
        }

        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        // 送付先住所を取得
        $shippingAddress = ShippingAddress::where('user_id', $user->id)
            ->where('item_id', $item_id)
            ->first();

        $selected = $request->query('payment_method', '選択してください');

        return view('purchase.index', compact('item', 'shippingAddress', 'selected'));
    }

    public function store(Request $request, $item_id)
    {
        $request->validate([
            'payment_method' => 'required|in:card,convenience',
        ], [
            'payment_method.required' => '支払い方法を選択してください。',
            'payment_method.in' => '正しい支払い方法を選択してください。',
        ]);

        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        // 売り切れチェック
        if ($item->sold_flg) {
            return back()->withErrors(['error' => 'この商品はすでに売り切れました。']);
        }

        $paymentMethod = $request->input('payment_method');

        // 配送先取得
        $shipping = ShippingAddress::where('user_id', $user->id)
            ->where('item_id', $item_id)
            ->first();

        // Stripe決済処理（カード支払い時）
        if ($paymentMethod === 'card') {
            try {
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
                    'success_url' => route('mypage.purchased_items') . '?success=true',
                    'cancel_url' => route('purchase.index', ['item_id' => $item->id]),
                ]);

                return redirect($session->url);
            } catch (\Exception $e) {
                Log::error('Stripeセッション作成エラー: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Stripe決済に失敗しました。管理者にお問い合わせください。']);
            }
        }

        // コンビニ支払いの場合はすぐに購入処理
        elseif ($paymentMethod === 'convenience') {
            if (!$shipping) {
                return back()->withErrors(['error' => '配送先が未設定です。']);
            }

            $item->sold_flg = true;
            $item->save();

            Purchase::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => $paymentMethod,
                'shipping_address' => "〒{$shipping->postal_code} {$shipping->prefecture} {$shipping->building}",
            ]);

            return redirect()->route('mypage.purchased_items')->with('success', '購入が完了しました（コンビニ支払い）');
        }
    }

    public function success($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        // 商品がすでに購入済みでないか確認
        if (!$item->sold_flg) {
            $item->sold_flg = true;
            $item->save();

            // 配送先取得
            $shipping = ShippingAddress::where('user_id', $user->id)
                ->where('item_id', $item_id)
                ->first();

            Purchase::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'payment_method' => 'card',
                'shipping_address' => $shipping
                    ? "〒{$shipping->postal_code} {$shipping->prefecture} {$shipping->building}"
                    : null,
            ]);
        }

        return redirect()->route('mypage.purchased_items')->with('success', 'カードでの購入が完了しました。');
    }

}