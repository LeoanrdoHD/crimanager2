<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    protected $fillable = [
        'province_name',
    ];
    public $timestamps = false;

}
