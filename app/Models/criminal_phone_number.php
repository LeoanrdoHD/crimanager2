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
}
