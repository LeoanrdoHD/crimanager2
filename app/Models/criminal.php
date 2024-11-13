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
        'country_id',
        'city_id',
        'province_id',
        'is_member_of_criminal_organization',
        'use_vehicle',
        'civil_state_id',
        'nationality_id',
        'alias_name',
        'ocupation_id',
    ];
    public function country()
    {
        return $this->belongsTo('app\Models\country');
    }
    public function city()
    {
        return $this->belongsTo('app\Models\city');
    }
    public function province()
    {
        return $this->belongsTo('app\Models\province');
    }
     public function ocupaction()
    {
        return $this->belongsTo('app\Models\ocupation');
    }
    public function nationality()
    {
        return $this->belongsTo('app\Models\nationality');
    }
    public function civil_state()
    {
        return $this->belongsTo('app\Models\civil_state');
    }
    public function arrest_and_apprehension_history()
    {
        return $this->hasMany('app\Models\arrest_and_apprehension_history'::class, 'criminal_id');
    }
    public function photograph()
    {
        return $this->hasMany('app\Models\photograph'::class, 'criminal_id');
    }
    public function organizations()
    {
        // belongsToMany indica que un criminal puede pertenecer a muchas organizaciones
        return $this->belongsToMany(Organization::class, 'criminal_organizations', 'criminal_id', 'organization_id');
    }
}
