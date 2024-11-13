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
    public function ear_type()
    {
        return $this->belongsTo('app\Models\ear_type');
    }
    public function eye_type()
    {
        return $this->belongsTo('app\Models\eye_type');
    }
    public function lip_type()
    {
        return $this->belongsTo('app\Models\lip_type');
    }
    public function nose_type()
    {
        return $this->belongsTo('app\Models\nose_type');
    }
    public function skin_color()
    {
        return $this->belongsTo('app\Models\skin_color');
    }
    public function confleccion()
    {
        return $this->belongsTo('app\Models\confleccion');
    }
    public function criminal_gender()
    {
        return $this->belongsTo('app\Models\criminal_gender');
    }
}
