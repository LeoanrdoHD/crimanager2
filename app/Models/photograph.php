<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class photograph extends Model
{
    protected $fillable = [
        'criminal_id',
        'frontal_photo',
        'full_body_photo',
        'profile_izq_photo',
        'profile_der_photo',
    ];
}
