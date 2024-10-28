<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class physical_characteristic extends Model
{
    protected $fillable = [
        'criminal_id',
        'height',
        'weight',
        'sex',
        'criminal_gender_id',
        'skin_color_id',
        'eye_type_id',
        'ear_type_id',
        'lip_type_id',
        'nose_type_id',
        'complexion',
        'distinctive_marks',
    ];
}
