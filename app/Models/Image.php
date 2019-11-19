<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    public $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'path', 'section',
    ];



    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'image_id');
    }

    public function post()
    {
        return $this->hasMany('App\Models\Post');
    }
}
