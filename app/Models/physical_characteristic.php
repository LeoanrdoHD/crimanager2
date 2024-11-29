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
        'confleccion_id',
        'distinctive_marks',
    ];
    public function criminal()
{
    return $this->belongsTo(Criminal::class, 'criminal_id');
}

public function earType()
{
    return $this->belongsTo(Ear_Type::class, 'ear_type_id');
}

public function eyeType()
{
    return $this->belongsTo(Eye_Type::class, 'eye_type_id');
}

public function lipType()
{
    return $this->belongsTo(Lip_Type::class, 'lip_type_id');
}

public function noseType()
{
    return $this->belongsTo(Nose_Type::class, 'nose_type_id');
}

public function skinColor()
{
    return $this->belongsTo(Skin_Color::class, 'skin_color_id');
}

public function Confleccion()
{
    return $this->belongsTo(Confleccion::class, 'confleccion_id');
}

public function criminalGender()
{
    return $this->belongsTo(Criminal_Gender::class, 'criminal_gender_id');
}

}
