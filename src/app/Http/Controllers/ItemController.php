<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->input('page') === 'mylist') {
            $items = $user ? $user->likedItems()->get() : collect();
        } else {
            $items = Item::when($user, function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id);
            })->get();
        }

        return view('index', compact('items'));
    }

    public function show($item_id)
    {
        $item = Item::with(['likes', 'comments', 'categories', 'brand', 'user'])->findOrFail($item_id);
        return view('items.show', compact('item'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('image')->store('items', 'public');

        $item = new Item();
        $item->user_id = auth()->id();
        $item->name = $request->name;
        $item->brand_name = $request->brand_name;
        $item->description = $request->description;
        $item->condition = $request->condition;
        $item->price = $request->price;
        $item->image_path = $path;
        $item->save();

        $item->categories()->attach($request->categories);

        return redirect()->route('index')->with('success', '商品を出品しました！');
    }


    public function myList()
    {
        if (!auth()->check()) {
            return view('mylist', ['items' => []]);
        }

        $user = auth()->user();

        $likedItems = $user->likes()
            ->where('user_id', '!=', $user->id)
            ->get();

        return view('mylist', ['items' => $likedItems]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $user = Auth::user();

        $items = Item::when($user, function ($q) use ($user) {

            $q->where('user_id', '!=', $user->id);
        })
            ->when($query, function ($q) use ($query) {

                $q->where('name', 'like', '%' . $query . '%');
            })
            ->get();

        return view('index', compact('items', 'query'));
    }
}
