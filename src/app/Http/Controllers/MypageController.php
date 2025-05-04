<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Routing\Controller;
use App\Http\Requests\ProfileRequest;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page');
        $user = auth()->user();

        if ($page === 'sell') {
            // 出品した商品を取得（user_idが自分のもの）
            $items = $user->items()->latest()->get();
        } elseif ($page === 'buy') {
            // 購入した商品を取得（purchasesテーブル経由）
            $items = \App\Models\Item::whereIn('id', function ($query) use ($user) {
                $query->select('item_id')
                    ->from('purchases')
                    ->where('user_id', $user->id);
            })->latest()->get();
        } else {
            // 初期表示など（アイテムなし）
            $items = collect();
        }

        return view('mypage.index', compact('page', 'items'));
    }

    public function edit(Request $request)
    {
        return view('mypage.edit');
    }

    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return redirect('/')->with('success', 'プロフィールを更新しました。');
    }

    public function purchaseItems()
    {
        $user = auth()->user();

        $purchases = Purchase::with('item')
            ->where('user_id', $user->id)
            ->get();

        // Purchase に紐づく Item を取り出す
        $items = $purchases->pluck('item')->filter();

        return view('items.index', compact('items'));
    }

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

}
