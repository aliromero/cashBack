<?php

namespace App;

use App\Models\Factor;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = ['product_id','customer_id','qty','video_id','vote_id','vote_p','status'];

    public function factors()
    {
        return $this->belongsToMany(Factor::class);
    }
}
