<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class criminal_complice extends Model
{
    protected $fillable = [
        'criminal_id',
        'arrest_and_apprehension_history_id',
        'complice_name',
        'CI_complice',
        'detail_complice',
    ];
}
