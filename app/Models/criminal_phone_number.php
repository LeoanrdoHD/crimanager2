<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_phone_number extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'phone_number',
        'company_id',
        'imei_number',
    ];

    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
    public function arrestHistories()
    {
        return $this->belongsTo(arrest_and_apprehension_history::class, 'arrest_and_apprehension_history_id');
    }
    public function company()
    {
        return $this->belongsTo(company::class, 'company_id');
    }
}
