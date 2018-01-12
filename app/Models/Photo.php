<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use CrudTrait;


    protected $table = 'photos';
    protected $primaryKey = 'id';
    public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['photo'];
    // protected $hidden = [];
    // protected $dates = [];


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }




}
