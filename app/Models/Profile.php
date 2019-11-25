<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Traits\ImageService;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use ImageService;

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

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
