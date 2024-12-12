<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prison extends Model
{
    protected $fillable = [
        'prison_name',
        'country_id',
        'city_id',
        'state_id',
        'prison_location',
    ];
    public $timestamps = false;
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
    public function criminals()
    {
        return $this->belongsToMany(Criminal::class, 'preventive_detention', 'prison_id', 'criminal_id');
    }

}
