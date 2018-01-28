<?php

namespace App;

use App\Models\Factor;
use App\Models\Product;
use App\Models\Shop;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\jDate;

class Cart extends Model
{
    use CrudTrait;
    protected $table = 'carts';
    protected $fillable = ['product_id','customer_id','qty','video_id','vote_id','vote_p','status','price'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }



    public function getStatus()
    {

        $status = self::find($this->id)->status;
        switch ($status) {
            case "WAITING" : return "منتظر ارسال رسید";
            case "POSTED" : return "منتظر تایید";
            case "FAILED" : return "رد شده";
            case "ACCEPTED" : return "تایید شده";
        }
        return "نا مشخص";
    }

    public function getImagesButton()
    {
        if($this->factors()->count() != null)
        return '<a href="'.url('admin/request/read/'.$this->id) .'" class="btn btn-xs btn-default"><i class="fa fa-image"></i>('.$this->factors()->count().') نمایش رسید</a>';

    }


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
