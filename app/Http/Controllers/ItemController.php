<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with('user')->latest()->get(); // 最新の商品を取得
        return view('items.index', compact('items'));
    }

    public function show($item_id)
    {
        $item = Item::with(['likes', 'comments', 'category', 'brand', 'user'])->findOrFail($item_id);
        return view('items.show', compact('item'));
    }
    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        // バリデーションと保存処理
    }

    public function myList()
    {
        if (!auth()->check()) {
            return view('mylist', ['items' => []]);
        }

        $user = auth()->user();

        $likedItems = $user->likes()
            ->where('user_id', '!=', $user->id) // 自分の出品商品を除く
            ->get();

        return view('mylist', ['items' => $likedItems]);
    }
}
