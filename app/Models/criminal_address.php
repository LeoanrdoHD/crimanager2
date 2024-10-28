<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_address extends Model
{
    protected $fillable = [

        'criminal_id',
        'street',
        'city_id',
        'nationality_id',
        
    ];
    
    public function city()
    {
        return $this->belongsTo('app\Models\city');
    }
    public function nationality()
    {
        return $this->belongsTo('app\Models\nationality');
    }
}
