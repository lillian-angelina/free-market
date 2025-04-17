<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

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
        $item = Item::with(['likes', 'comments', 'categories', 'brand', 'user'])->findOrFail($item_id);
        return view('items.show', compact('item'));
    }
    public function create()
    {
        $categories = Category::all(); // カテゴリ一覧を取得
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'categories' => 'required|array',
            'condition' => 'required|string',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:1',
        ]);

        // 画像アップロード処理
        $path = $request->file('image')->store('items', 'public');

        $item = new Item();
        $item->user_id = auth()->id();
        $item->name = $request->name;
        $item->brand = $request->brand;
        $item->description = $request->description;
        $item->condition = $request->condition;
        $item->price = $request->price;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $item->image_path = $path;
        }

        $item->save();

        // 複数選択されたカテゴリを保存
        if ($request->has('categories')) {
            $item->categories()->attach($request->categories);
        }

        return redirect()->route('items.index')->with('success', '商品を出品しました！');
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
