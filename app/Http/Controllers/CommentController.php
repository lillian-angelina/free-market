<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $item_id)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'item_id' => $item_id,
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        return redirect()->route('items.show', ['item_id' => $item_id]);
    }
}
