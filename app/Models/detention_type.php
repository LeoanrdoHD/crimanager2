<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detention_type extends Model
{
    protected $fillable = [
        'detention_name',
    ];
    public function criminalConviction()
    {
        return $this->hasMany(conviction::class, 'conviction_id');
    }
    public function extraditions()
    {
        return $this->hasMany(Extradition::class, 'conviction_id');
    }

    public function houseArrests()
    {
        return $this->hasMany(house_arrest::class, 'conviction_id');
    }

    public function preventiveDetentions()
    {
        return $this->hasMany(preventive_detention::class, 'conviction_id', 'detention_type_id');
    }

    public function liberties()
    {
        return $this->hasMany(Liberty::class, 'conviction_id');
    }
}
