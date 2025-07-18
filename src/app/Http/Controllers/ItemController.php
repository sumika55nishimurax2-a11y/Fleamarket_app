<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\ItemCondition;
use App\Models\Like;
use App\Models\Comment;



class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');


        if (auth()->check()) {
            $userId = auth()->id();

            $mylist = auth()->user()->likes()->with('item')->get()->pluck('item')->filter();


            $productIdsInMylist = $mylist->pluck('id')->filter();



            $products = Item::where('user_id', '!=', $userId)
                ->whereNotIn('id', $productIdsInMylist)
                ->when($keyword, function ($query, $keyword) {
                    return $query->where(function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%")
                            ->orWhere('description', 'like', "%{$keyword}%");
                    });
                })
                ->get();

            if ($keyword) {
                $mylist = $mylist->filter(function ($item) use ($keyword) {
                    return str_contains($item->name, $keyword) || str_contains($item->description, $keyword);
                });
            }
        } else {
            $products = Item::when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            })->get();

            $mylist = collect(); // 空のコレクション
        }

        return view('item.index', compact('products', 'mylist', 'keyword'));
    }


    public function show($id)
    {
        $item = Item::with(['categories', 'condition', 'likes', 'comments.user'])->findOrFail($id);

        return view('item.show', [
            'item' => $item,
            'comments' => $item->comments,
        ]);
    }


    public function create()
    {
        $categories = Category::all(); // ← categoryテーブルから全取得
        $conditions = ItemCondition::all(); // ← 状態（condition）もDBから取得しているなら

        return view('item.create', compact('categories', 'conditions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'condition' => 'required|exists:conditions,id',
            'image' => 'required|image|max:2048',
            'category' => 'required|array',
            'category.*' => 'exists:categories,id',
        ]);

        $path = $request->file('image')->store('images', 'public');

        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'condition_id' => $validated['condition'],
            'image_path' => $path,
        ]);

        if ($request->has('category')) {
            $item->categories()->attach($validated['category']);
        }

        return redirect()->route('item.show', $item->id)->with('success', '商品を出品しました');
    }
}
