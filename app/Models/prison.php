<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prison extends Model
{
    protected $fillable = [
        'prison_name',
        'country_id',
        'city_id',
        'province_id',
        'prison_location',
    ];
    public $timestamps = false;
    public function country()
    {
        return $this->belongsTo('app\Models\country');
    }
    public function city()
    {
        return $this->belongsTo('app\Models\city');
    }
    public function province()
    {
        return $this->belongsTo('app\Models\province');
    }

}
