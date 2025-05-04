<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name'];

    // Itemとのリレーション（1対多）
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
