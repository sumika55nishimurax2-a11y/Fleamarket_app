<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Auth;



class PurchaseController extends Controller
{
    public function index(Item $item)
    {
        $user = Auth::user()->refresh();

        // ログインユーザーが自分の商品を買おうとしていたら拒否
        if ($item->user_id === auth()->id()) {
            return redirect()->route('items.show', $item->id)->with('error', '自分の商品は購入できません');
        }

        $paymentMethods = PaymentMethod::all();
        $selectedPaymentMethod = old('payment_method'); // 直前に選んだやつがあれば

        return view('purchase.purchase', compact('item', 'user', 'paymentMethods', 'selectedPaymentMethod'));
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

        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

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


        return redirect()->route('checkout.success');
    }

    public function complete()
    {
        return view('checkout.success');
    }
}
