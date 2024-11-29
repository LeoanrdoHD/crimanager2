<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_address extends Model
{
    protected $fillable = [

        'criminal_id',
        'arrest_and_apprehension_history_id',
        'country_id',
        'city_id',
        'state_id',
        'street',

    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
}
