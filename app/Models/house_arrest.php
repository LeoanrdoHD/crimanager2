<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class house_arrest extends Model
{
    protected $fillable = [
        'criminal_id',
        'conviction_id',
        'house_arrest_address',
        'country_id',
        'city_id',
        'state_id',
    ];
}
