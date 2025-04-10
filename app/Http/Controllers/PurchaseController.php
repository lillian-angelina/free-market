<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class PurchaseController extends Controller
{
    public function index($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('purchase.index', compact('item'));
    }

    public function confirm(Request $request, $item_id)
    {
        // 購入処理
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('purchase.address', compact('item'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        // 住所更新処理
    }
}
