<?php

namespace App\Models;

use App\Models\User;
use App\Models\Image;
use App\Traits\ImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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

    public function following()
    {
        return $this->belongsToMany('App\Models\Profile', 'followers', 'sender_id', 'accepter_id')
            ->withPivot(['status']);

    }

    public function AuthId(){

        $profile = Profile::where('id' ,Auth::id())->first();

        return $profile;
    }

    public function followers()
    {
        return $this->belongsToMany('App\Models\Profile', 'followers', 'accepter_id', 'sender_id')
            ->withPivot(['status']);
    }
}
