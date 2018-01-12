<?php

namespace App\Models;

use App\Scopes\RepScope;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class Shop extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'shops';
    protected $primaryKey = 'id';
     public $timestamps = true;
    // protected $guarded = ['id'];
     protected $fillable = ['name','address','tell','logo','latitude','longitude','manager_name','contract_number','contract_src','status'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope('id', function (Builder $builder) {
//
//        });
//    }



    public function getFactorsButton()
    {
        return '<a href="'.url('admin/request/read/'.$this->id) .'" class="btn btn-xs btn-default" data-button-type="read"><i class="fa fa-sticky-note"></i> مدیریت رسیدها</a>';

    }

    public function getReportsButton()
    {
        return '<a href="'.url('admin/request/read/'.$this->id) .'" class="btn btn-xs btn-default" data-button-type="read"><i class="fa fa-bar-chart"></i> مدیریت گزارشات</a>';

    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function cities()
    {
        return $this->belongsToMany(City::class);
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function banners()
    {
        return $this->belongsToMany(Banner::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
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
        return $query->join('shop_user','shop_user.shop_id' , '=' ,'shops.id')
            ->select('shops.*')
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


    public function setLogoAttribute($value)
    {
        $attribute_name = "logo";
        $disk = "uploads";
        $destination_path = "logos";
        $destination_path_thumb = "thumb_logos";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->logo);

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            $image_thumb = \Image::make($value);
            $image_thumb->resize(250, 250);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            \Storage::disk($disk)->put($destination_path_thumb.'/'.$filename, $image_thumb->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }


    public function setContractSrcAttribute($file)
    {
        $attribute_name = "contract_src";
        $disk = "uploads";
        $destination_path = "contracts";
        $name = md5($file.time());

        if ($file==null) {

            \Storage::disk($disk)->delete($this->contract_src);

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        } else {
            Storage::disk($disk)->put($destination_path . "/" . $name . "." . $file->getClientOriginalExtension(), File::get($file));
            $this->attributes[$attribute_name] = $destination_path . '/' . $name . "." . $file->getClientOriginalExtension();
        }

    }

}
