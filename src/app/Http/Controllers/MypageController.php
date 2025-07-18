<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        $product = $user->items()->latest()->get();

        $soldItems = $user->items()->latest()->get();

        $boughtOrders = $user->orders()->with('item')->latest()->get();

        return view('profile.mypage', compact('user', 'soldItems', 'boughtOrders'));
    }
}
