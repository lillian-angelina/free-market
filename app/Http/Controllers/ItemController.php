<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->input('page') === 'mylist') {
            $items = $user ? $user->likedItems()->get() : collect();
        } else {
            $items = Item::all();
        }

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
        // TODO: バリデーションと保存処理
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

    public function search(Request $request)
    {
        $query = $request->input('query');

        $items = Item::when($query, function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
        })->get();

        return view('items.index', compact('items', 'query'));
    }
}
