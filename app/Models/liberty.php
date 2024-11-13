<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class liberty extends Model
{
    protected $fillable = [
        'conviction_id',
        'house_address',
        'country_id',
        'city_id',
        'province_id',
    ];
}
