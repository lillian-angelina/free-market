<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page');
        return view('mypage.index', compact('page'));
    }

    public function edit()
    {
        return view('mypage.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

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

        return redirect()->back()->with('success', 'プロフィールを更新しました。');
    }
}
