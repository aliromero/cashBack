<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = ['src'];
    public $timestamps = false;

    public function factors()
    {
        return $this->belongsToMany(Factor::class);
    }
}
