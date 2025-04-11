<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'price', 'condition', 'image_path'];

    // 出品者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // 購入されたかどうかをチェック（例: sold_flg など）
    public function isSold()
    {
        return $this->sold_flg; // true or false
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy($user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
