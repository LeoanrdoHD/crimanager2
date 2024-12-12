<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class arrest_and_apprehension_history extends Model
{
    protected $fillable = [
        'criminal_id',
        'legal_status_id',
        'apprehension_type_id',
        'cud_number',
        'arrest_date',
        'arrest_time',
        'arrest_location',
        'criminal_specialty_id',
        'arrest_details',
    ];
    public function criminal()
    {
        return $this->belongsTo(Criminal::class, 'criminal_id');
    }
    
    public function legalStatus()
    {
        return $this->belongsTo(legal_statuse::class, 'legal_status_id');
    }
    
    public function apprehensionType()
    {
        return $this->belongsTo(Apprehension_Type::class, 'apprehension_type_id');
    }
    
    public function detentionType()
    {
        return $this->belongsTo(Detention_Type::class, 'detention_type_id');
    }
    public function criminalSpecialty()
    {
        return $this->belongsTo(criminal_specialty::class, 'criminal_specialty_id');
    }
    public function criminalTools()
    {
        return $this->hasMany(criminal_tool::class, 'arrest_and_apprehension_history_id');
    }  
    public function phoneNumber()
    {
        return $this->hasMany(criminal_phone_number::class, 'arrest_and_apprehension_history_id');
    }  

    public function criminalAliase()
    {
        return $this->hasMany(criminal_aliase::class, 'arrest_and_apprehension_history_id');
    }  
    public function criminalComplice()
    {
        return $this->hasMany(criminal_complice::class, 'arrest_and_apprehension_history_id');
    }  
    public function criminalOrganization()
    {
        return $this->hasMany(criminal_organization::class, 'arrest_and_apprehension_history_id');
    }  
    public function criminalVehicle()
    {
        return $this->hasMany(criminal_vehicle::class, 'arrest_and_apprehension_history_id');
    }  
    public function criminalConviction()
    {
        return $this->hasMany(conviction::class, 'arrest_and_apprehension_history_id');
    }  
    public function extraditions()
    {
        return $this->hasMany(Extradition::class, 'arrest_and_apprehension_history_id');
    }

    public function houseArrests()
    {
        return $this->hasMany(house_arrest::class, 'arrest_and_apprehension_history_id');
    }

    public function preventiveDetentions()
    {
        return $this->hasMany(preventive_detention::class, 'arrest_and_apprehension_history_id');
    }

    public function liberties()
    {
        return $this->hasMany(Liberty::class, 'arrest_and_apprehension_history_id');
    }
}
