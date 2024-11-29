<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class criminal extends Model
{
    use HasFactory;
    protected $fillable = [

        'first_name',
        'last_nameP',
        'last_nameM',
        'identity_number',
        'date_of_birth',
        'age',
        'country_id',
        'city_id',
        'state_id',
        'is_member_of_criminal_organization',
        'use_vehicle',
        'civil_state_id',
        'nationality_id',
        'alias_name',
        'ocupation_id',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function civilState()
    {
        return $this->belongsTo(Civil_State::class, 'civil_state_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function occupation()
    {
        return $this->belongsTo(Ocupation::class, 'ocupation_id');
    }
    public function arrest_and_apprehension_history()
    {
        return $this->hasMany('app\Models\arrest_and_apprehension_history'::class, 'criminal_id');
    }
    public function photographs()
    {
        return $this->hasMany(\App\Models\Photograph::class, 'criminal_id');
    }
    public function criminalAddresses()
    {
        return $this->hasMany(Criminal_Address::class, 'criminal_id');
    }
    public function PhysicalCharacteristics()
    {
        return $this->hasMany(\App\Models\physical_characteristic::class, 'criminal_id');
    }
    public function criminalPartner()
    {
        return $this->hasMany(\App\Models\criminal_partner::class, 'criminal_id');
    }

    public function organizations()
    {
        // belongsToMany indica que un criminal puede pertenecer a muchas organizaciones
        return $this->belongsToMany(Organization::class, 'criminal_organizations', 'criminal_id', 'organization_id');
    }
    public function arrestHistories()
    {
        return $this->hasMany(arrest_and_apprehension_history::class, 'criminal_id');
    }
    public function Phone()
    {
        return $this->hasMany(criminal_phone_number::class, 'criminal_id');
    }
    public function prision()
    {
        // belongsToMany indica que un criminal puede pertenecer a muchas organizaciones
        return $this->belongsToMany(prison::class, 'preventive_detentions', 'criminal_id', 'prison_id');
    }
}
