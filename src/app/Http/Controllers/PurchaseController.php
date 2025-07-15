<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;



class PurchaseController extends Controller
{
    public function index(Item $item)
    {
        // ログインユーザーが自分の商品を買おうとしていたら拒否
        if ($item->user_id === auth()->id()) {
            return redirect()->route('items.show', $item->id)->with('error', '自分の商品は購入できません');
        }

        $user = Auth::user();
        $paymentMethods = PaymentMethod::all();

        return view('purchase.purchase', compact('item', 'user', 'paymentMethods'));
    }

    public function show(Item $item)
    {
        $user = Auth::user();
        return view('purchase.purchase', compact('item', 'user'));
    }

    public function editAddress(Item $item)
    {
        $user = Auth::user();
        return view('purchase.address', compact('user', 'item'));
    }

    public function updateAddress(Request $request, Item $item)
    {
        $request->validate([
            'postal_code' => 'required|string|max:8',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->update($request->only(['postal_code', 'address', 'building']));

        return redirect()->route('purchase.index', ['item' => $item->id])
            ->with('success', '住所が更新されました');
    }

    // 購入処理
    public function store(Request $request, Item $item)
    {


        $request->validate([
            'payment_method' => 'required',
        ]);

        Order::create([
            'buyer_id' => Auth::id(),
            'item_id' => $item->id,
            'shipping_address' => Auth::user()->postal_code . ' ' . Auth::user()->address . ' ' . Auth::user()->building,
            'payment_method_id' => PaymentMethod::where('name', $request->payment_method)->first()->id,
        ]);

        $item->update(['is_sold' => true]);


        return redirect()->route('purchase.complete');
    }

    public function complete()
    {
        return view('purchase.complete');
    }
}
