<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    protected $table = 'exports_file_table';

    public $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'export_path_file', 'processing','user_id'
    ];
}
