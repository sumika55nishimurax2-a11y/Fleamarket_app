<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * コメント保存処理
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:1000',
        ]);

        // 保存処理
        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'content' => $validated['content'],
        ]);

        return redirect()->back()->with('success', 'コメントを投稿しました。');
    }
}
