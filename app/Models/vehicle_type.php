<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vehicle_type extends Model
{
    protected $fillable = [
        'vehicle_type_name',
    ];
    public $timestamps = false;
}
