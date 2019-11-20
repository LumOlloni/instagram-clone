<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    public $primaryKey = 'id';

    public $timestamps = true;
    protected $fillable = ['user_id', 'post_id', 'body', 'published', 'parent_id'];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
