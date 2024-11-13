<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class arrest_and_apprehension_history extends Model
{
    protected $fillable = [
        'criminal_id',
        'legal_status_id',
        'apprehension_type_id',
        'cud_number',
        'arrest_date',
        'arrest_time',
        'arrest_location',
        'criminal_specialty_id',
        'arrest_details',
    ];
    public function criminal()
    {
        return $this->belongsTo('app\Models\criminal');
    }
    public function legal_status()
    {
        return $this->belongsTo('app\Models\legal_status');
    }

    public function apprehension_type()
    {
        return $this->belongsTo('app\Models\apprehension_type');
    }
    public function detention_type()
    {
        return $this->belongsTo('app\Models\detention_type');
    }
}
