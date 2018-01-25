<?php

namespace App;

use App\Models\Factor;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = ['product_id','customer_id','qty','video_id','vote_id','vote_p','status'];


    public function getCreatedAtAttribute($value)
    {

        return jDate::forge($value)->format('%d %B، %Y / ساعت : H:i');
    }


    public function getUpdatedAtAttribute($value)
    {

        return jDate::forge($value)->format('%d %B، %Y / ساعت : H:i');
    }

    public function factors()
    {
        return $this->belongsToMany(Factor::class);
    }
}
