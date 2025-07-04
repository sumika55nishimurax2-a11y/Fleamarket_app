<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;



class ItemController extends Controller
{
    public function index(Request $request)
    {

        $keyword = $request->input('keyword');

        if (auth()->check()) {
            $userId = auth()->id();

            // 自分が出品していない商品のみ

            $products = Item::where('user_id', '!=', $userId)
                ->when($keyword, function ($query, $keyword) {
                    return $query->where(function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%")
                            ->orWhere('description', 'like', "%{$keyword}%");
                    });
                })
                ->get();

            // 自分のマイリスト商品（いいね）
            $mylist = auth()->user()->likes()->with('item')->get()->pluck('item');
        } else {

            $products = Item::when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            })->get();

            $mylist = collect(); // 空
        }

        return view('item.index', compact('products', 'mylist', 'keyword'));
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);

        $comments = Comment::where('item_id', $id)->get();

        return view('item.show', compact('item', 'comments'));
    }


    public function create()
    {
        return view('item.create');
    }
}
