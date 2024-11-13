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
        'province_id',
        'street',
        
    ];
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
