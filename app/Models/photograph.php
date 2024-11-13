<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class photograph extends Model
{
    protected $fillable = [
        'criminal_id',
        'face_photo',
        'frontal_photo',
        'full_body_photo',
        'profile_izq_photo',
        'profile_der_photo',
        'aditional_photo',
        'barra_photo',
    ];
    public function criminal()
    {
        return $this->belongsTo('app\Models\criminal');
    }
}
