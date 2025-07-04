<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\User;

class Order extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class); // 購入した商品
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}
