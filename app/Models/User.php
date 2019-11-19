<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username',  'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id')->withTimestamps();
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function post()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'id');
    }

    public function tagUserName($tag)
    {
        $user = User::all();

        $username = ['lummche'];
        $array = [];

        foreach ($user as $key) {
            $array = [$key->username];
            if (in_array($username,  $array)) {
                // if ('qendro' == $key->username) {
                // return true;
                // dd("Success");
            } else {
                // return false;
                dd("Error");
            }
        }
    }
}
