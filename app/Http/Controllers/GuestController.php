<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class GuestController extends Controller
{
    public function index()
    {
        $items = Item::with('user')->latest()->get(); // 最新の商品を取得
        return view('guest.index', compact('items'));
    }

    public function show(Item $item)
    {
        $item->load('user'); // 出品者の情報も取得
        return view('guest.show', compact('item'));
    }
}
