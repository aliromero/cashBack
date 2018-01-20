<?php

namespace App\Models;

use App\Cart;
use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{

    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class);
    }
}
