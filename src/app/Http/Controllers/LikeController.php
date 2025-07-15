<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;

class LikeController extends Controller
{
    public function toggle(Request $request, Item $item)
    {
        $user = auth()->user();

        // すでにいいね済みなら解除
        if ($item->likes()->where('user_id', $user->id)->exists()) {
            $item->likes()->where('user_id', $user->id)->delete();
        } else {
            $item->likes()->create([
                'user_id' => $user->id,
            ]);
        }

        return back();
    }
}
