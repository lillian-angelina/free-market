<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $itemId)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'item_id' => $itemId,
            'user_id' => auth()->id(),
            'body' => $request->input('body'),
        ]);

        return redirect()->back()->with('success', 'コメントを投稿しました。');
    }
}
