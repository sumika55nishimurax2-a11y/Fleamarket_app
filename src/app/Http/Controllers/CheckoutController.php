<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Item;


class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $item = Item::findOrFail($request->item_id);
        $paymentMethod = $request->payment_method;

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => $paymentMethod === 'コンビニ支払い' ? ['konbini'] : ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount' => $item->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        session(['purchased_item_id' => $item->id]);

        return redirect($session->url);
    }

    public function success()
    {
        $itemId = session('purchased_item_id');

        if ($itemId) {
            $item = Item::find($itemId);
            if ($item && !$item->is_sold) {
                $item->is_sold = 1;
                $item->save();
            }
            // セッションの削除（2回目以降アクセスした時の重複防止）
            session()->forget('purchased_item_id');
        }


        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }
}
