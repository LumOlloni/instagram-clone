<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    public $primaryKey = 'id';

    public $timestamps = true;
    protected $fillable = ['user_id', 'bio', 'image_id', 'is_public'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function images()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
