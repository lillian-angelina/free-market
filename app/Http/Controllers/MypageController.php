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
        // プロフィール更新処理
    }
}
