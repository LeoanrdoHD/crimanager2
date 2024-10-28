<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class criminal extends Model
{
    use HasFactory;
    protected $fillable = [

        'first_name',
        'last_name',
        'identity_number',
        'date_of_birth',
        'age',
        'is_member_of_criminal_organization',
        'use_vehicle',
        'civil_state_id',
        'nationality_id',
        'criminal_specialty_id',
    ];

    public function civil_state()
    {
        return $this->belongsTo('app\Models\civil_state');
    }

    public function nationality()
    {
        return $this->belongsTo('app\Models\nationality');
    }
    public function criminal_speciality()
    {
        return $this->belongsTo('app\Models\criminal_speciality');
    }
}
