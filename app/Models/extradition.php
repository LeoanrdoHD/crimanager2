<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class extradition extends Model
{
    protected $fillable = [
        'criminal_id',
        'conviction_id',
        'country_id',
        'city_id',
        'extradition_date',
    ];
}
