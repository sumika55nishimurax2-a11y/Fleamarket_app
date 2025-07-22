<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;
use App\Models\Category;
use App\Models\User;
use App\Models\ItemCondition;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'brand', 'description', 'price', 'condition_id', 'image_path', 'is_sold'];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function condition()
    {
        return $this->belongsTo(ItemCondition::class, 'condition_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // 出品者
    }
}
