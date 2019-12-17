<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    public $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'notifiable_type', 'notifiable_id','data',
    ];
}
