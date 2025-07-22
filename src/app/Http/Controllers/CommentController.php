<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:255',
            'item_id' => 'required|exists:items,id',
        ]);

        Comment::create([
            'comment' => $validated['comment'],
            'user_id' => auth()->id(),
            'item_id' => $validated['item_id'],
        ]);

        return redirect()->route('items.show', $validated['item_id'])->with('success', 'コメントを投稿しました');
    }
}
