<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ImagePost;

class Post extends Model
{
    use ImagePost;

    protected $table = 'posts';
    public $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'image_id', 'description', 'user_id'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class , 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
