<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function images()
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tags');
    }
}
