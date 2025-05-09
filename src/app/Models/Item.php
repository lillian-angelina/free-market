<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Category;

class Item extends Model
{
    protected $fillable = ['user_id', 'name', 'description', 'price', 'category', 'condition', 'image_path', 'brand_id'];

    protected $casts = [
        'sold_flg' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function isSold()
    {
        return $this->sold_flg;
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
