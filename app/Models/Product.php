<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Facades\jDate;
use Morilog\Jalali\jDateTime;

class Product extends Model
{
    use CrudTrait;

    /*
   |--------------------------------------------------------------------------
   | GLOBAL VARIABLES
   |--------------------------------------------------------------------------
   */

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'image', 'shop_id', 'price', 'description', 'discount', 'status', 'discount_type','vote_id','video_id','discount_exp','discount_limit'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */






    public function getDisType()
    {
        return self::find($this->id)->discount_type;
    }


    public function getCreatedAt()
    {
        $date = self::find($this->id)->created_at;
        return jDate::forge($date)->format('%d %B، %Y / ساعت : H:i');
    }

    public function getUpdatedAt()
    {
        $date = self::find($this->id)->updated_at;
        return jDate::forge($date)->format('%d %B، %Y / ساعت : H:i');
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {

        return $this->belongsToMany(Tag::class);
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
    public function scopeRep($query)
    {
        return $query
            ->select('products.name','products.shop_id','products.discount')
//            ->select(DB::Raw('products.id AS id,products.name AS name,products.shop_id AS shop_id,products.discount AS discount,products.discount_exp AS discount_exp'))
            ->join('shops','shops.id' , '=' ,'products.shop_id')
            ->join('shop_user','shop_user.shop_id' , '=' ,'shops.id')
            ->where('shop_user.user_id',Auth::user()->id);


    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setDiscountExpAttribute($value)
    {


        if (preg_match('#^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})#', $value, $matches)) {
            $year = $matches[1];
            $month   = $matches[2];
            $day  = $matches[3];
            $hour = $matches[4];
            $min = $matches[5];
            $s = $matches[6];
        }

//        dd($s);


        $date = jDateTime::toGregorian($year,$month,$day);
         $time = jDate::forge("{$date[0]}-{$date[1]}-{$date[2]} {$hour}:{$min}:{$s}")->time();
//        dd(Carbon::createFromTimestamp($time)->toDateTimeString());
        $this->attributes['discount_exp'] = Carbon::createFromTimestamp($time)->toDateTimeString();
    }

    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "products";
        $destination_path_thumb = "thumb_products";

        // if the image was erased
        if ($value == null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->image);

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($value);
            $image_thumb = \Image::make($value);
            $image_thumb->resize(250, 250);
            // 1. Generate a filename.
            $filename = md5($value . time()) . '.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path . '/' . $filename, $image->stream());
            \Storage::disk($disk)->put($destination_path_thumb . '/' . $filename, $image_thumb->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path . '/' . $filename;
        }
    }
}
